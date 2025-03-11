<?php
require_once __DIR__ . '/utils.php';
require_once __DIR__ . "/crest/crest.php";
require_once __DIR__ . "/crest/crestcurrent.php";

class DocumentGenerator
{
    private const TEMPLATES = [
        'salary_certificate' => 'Salary.docx',
        'noc' => 'NOC.docx'
    ];

    private $templateDir;
    private $user;

    public function __construct()
    {
        $this->templateDir = __DIR__ . "/templates/";
    }

    public function generate(): void
    {
        try {
            $this->validateRequest();
            $this->loadUserData();
            $this->processDocument();
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    private function validateRequest(): void
    {
        if (!isset($_POST['documentType'])) {
            throw new Exception("No document type specified.");
        }

        if (!isset(self::TEMPLATES[$_POST['documentType']])) {
            throw new Exception("Invalid document type.");
        }
    }

    private function loadUserData(): void
    {
        $currentUser = CRestCurrent::call('user.current');
        if (!isset($currentUser['result']['ID'])) {
            throw new Exception("Failed to get current user.");
        }

        $this->user = getUserInfo($currentUser['result']['ID']);
        if (!$this->user) {
            throw new Exception("User information could not be retrieved.");
        }
    }

    private function formatFullName(): string
    {
        $nameParts = array_map(function ($part) {
            return ucwords(strtolower(trim($part)));
        }, [
            $this->user['NAME'],
            $this->user['SECOND_NAME'],
            $this->user['LAST_NAME']
        ]);

        return preg_replace('/\s+/', ' ', implode(' ', array_filter($nameParts)));
    }

    private function getTemplatePath(): string
    {
        $template = self::TEMPLATES[$_POST['documentType']];
        $templatePath = $this->templateDir . $template;

        if (!file_exists($templatePath)) {
            throw new Exception("Template file not found.");
        }

        return $templatePath;
    }

    private function processDocument(): void
    {
        $templatePath = $this->getTemplatePath();
        $fullName = $this->formatFullName();
        $sanitizedFileName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $fullName);

        $wordFile = generateWordDocument(
            $templatePath,
            $this->user,
            $_POST['startDate'] ?? null,
            $_POST['endDate'] ?? null,
            $_POST['currentSalaryNoc'] ?? null,
            $_POST['currentSalary'] ?? null,
            $_POST['addressTo'] ?? null,
            $_POST['addressToNoc'] ?? null,
            $_POST['nocReason'] ?? null,
            $_POST['country'] ?? 'UAE'
        );

        if (!$wordFile) {
            throw new Exception("Failed to generate the document.");
        }

        $this->sendFile($wordFile, $sanitizedFileName);
    }

    private function sendFile(string $wordFile, string $sanitizedFileName): void
    {
        $template = self::TEMPLATES[$_POST['documentType']];
        $filename = basename($template, '.docx') . '_' . $sanitizedFileName . '.docx';

        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($wordFile));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        header('Pragma: public');

        readfile($wordFile);
        unlink($wordFile);
        exit;
    }

    private function handleError(string $message): void
    {
        header('HTTP/1.1 400 Bad Request');
        echo $message;
        exit;
    }
}

// Usage
$generator = new DocumentGenerator();
$generator->generate();
