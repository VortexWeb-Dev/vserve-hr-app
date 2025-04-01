<?php

require 'vendor/autoload.php';
require_once 'crest/crest.php';
// Removed the recursive require_once 'utils.php'

use PhpOffice\PhpWord\TemplateProcessor;

function formatDateRange($startDate, $endDate)
{
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);

    return sprintf(
        "%s to the %s of %s %s",
        $start->format('jS'),
        $end->format('jS'),
        $start->format('F'),
        $start->format('Y')
    );
}

/**
 * Modified generateWordDocument function that supports both dynamic values arrays
 * (for salary_certificate and similar) and the older fixed parameter signature.
 */
function generateWordDocument($templatePath, $user, ...$args)
{
    if (!file_exists($templatePath)) {
        error_log("Template file does not exist: $templatePath");
        return null;
    }

    $templateProcessor = new TemplateProcessor($templatePath);

    // If the third parameter is an array, use it as the dynamic values
    if (isset($args[0]) && is_array($args[0])) {
        $dynamicValues = $args[0];

        // Loop through the dynamic values and set them in the template
        foreach ($dynamicValues as $placeholder => $value) {
            // TemplateProcessor placeholders in your DOCX are defined like ${PLACEHOLDER}
            $templateProcessor->setValue($placeholder, $value);
        }
    } else {
        // Original behavior for NOC and other document types
        // Expected parameters:
        // $startDate, $endDate, $salaryNoc, $salary, $address_to, $address_to_noc, $noc_reason, $country
        list($startDate, $endDate, $salaryNoc, $salary, $address_to, $address_to_noc, $noc_reason, $country) = $args;

        $templateData = [
            'FULL_NAME'       => trim($user['NAME'] . ' ' . $user['LAST_NAME']),
            'NATIONALITY'     => $user['PERSONAL_COUNTRY'],
            'PASSPORT_NUMBER' => $user['UF_USR_1737788340786'],
            'DATE_OF_JOINING' => (new DateTime($user['UF_EMPLOYMENT_DATE']))->format('F Y'),
            'POSITION'        => $user['WORK_POSITION'],
            'SALARY'          => $salary,
            'SALARY_NOC'      => $salaryNoc,
            'ADDRESS_TO'      => $address_to,
            'ADDRESS_TO_NOC'  => $address_to_noc,
            'CURRENT_DATE'    => getTodayDateFormatted(),
            'NOC_SENTENCE'    => generateNocSentence($noc_reason, $country, formatDateRange($startDate, $endDate)),
            'NOC_REASON'      => generateNocReasonText($noc_reason, $country),
        ];

        foreach ($templateData as $placeholder => $value) {
            $templateProcessor->setValue($placeholder, $value);
        }
    }

    // Save the document to a temporary file
    $tempFile = tempnam(sys_get_temp_dir(), 'docx');
    $templateProcessor->saveAs($tempFile);

    return $tempFile;
}

function getUserInfo($userId)
{
    $userResponse = CRest::call('user.get', ['ID' => $userId]);
    return $userResponse['result'][0] ?? null;
}

function getTodayDateFormatted()
{
    return date('jS F Y');
}

function generateNocSentence($noc_reason, $country, $travel_date)
{
    $nocSentence = '';

    switch ($noc_reason) {
        case 'visa_application':
            $nocSentence = "will be applying for a $country Visa.";
            break;
        case 'travel':
            $nocSentence = "will be traveling to $country from the $travel_date.";
            break;
        case 'mortgage_application':
            $nocSentence = "will be applying for a mortgage loan in $country.";
            break;
        case 'credit_card_application':
            $nocSentence = "will be applying for a credit card in $country.";
            break;
        case 'debit_card_application':
            $nocSentence = "will be applying for a debit card in $country.";
            break;
        case 'bank_account_opening':
            $nocSentence = "will be applying to open a bank account in $country.";
            break;
        default:
            $nocSentence = "will be applying for necessary processes in $country.";
            break;
    }

    return $nocSentence;
}

function generateNocReasonText($noc_reason, $country)
{
    $nocReasonText = '';

    switch ($noc_reason) {
        case 'visa_application':
            $nocReasonText = "No Objection Letter for $country Visa Application and Travel.";
            break;
        case 'travel':
            $nocReasonText = "No Objection Letter for Travel to $country.";
            break;
        case 'mortgage_application':
            $nocReasonText = "No Objection Letter for applying for a mortgage loan in $country.";
            break;
        case 'credit_card_application':
            $nocReasonText = "No Objection Letter for applying for a credit card in $country.";
            break;
        case 'debit_card_application':
            $nocReasonText = "No Objection Letter for applying for a debit card in $country.";
            break;
        case 'bank_account_application':
            $nocReasonText = "No Objection Letter for opening a bank account in $country.";
            break;
        default:
            $nocReasonText = "No Objection Letter for necessary processes in $country.";
            break;
    }

    return $nocReasonText;
}
