<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Stimulsoft\Events\StiDataEventArgs;
use Stimulsoft\Events\StiEmailEventArgs;
use Stimulsoft\Events\StiExportEventArgs;
use Stimulsoft\Events\StiPrintEventArgs;
use Stimulsoft\Events\StiVariablesEventArgs;
use Stimulsoft\Events\StiReportEventArgs;
use Stimulsoft\StiHandler;
use Stimulsoft\StiResult;


class HandlerController extends BaseController
{
    public function process()
    {
        $handler = new StiHandler();
        $handler->onBeforeRender = [$this, 'onBeforeRender'];
        $handler->onPrepareVariables = [$this, 'onPrepareVariables'];
        $handler->onBeginProcessData = [$this, 'onBeginProcessData'];
        $handler->onEndProcessData = [$this, 'onEndProcessData'];
        $handler->onPrintReport = [$this, 'onPrintReport'];
        $handler->onBeginExportReport = [$this, 'onBeginExportReport'];
        $handler->onEndExportReport = [$this, 'onEndExportReport'];
        $handler->onEmailReport = [$this, 'onEmailReport'];
        $handler->onCreateReport = [$this, 'onCreateReport'];
        $handler->onSaveReport = [$this, 'onSaveReport'];
        $handler->onSaveAsReport = [$this, 'onSaveAsReport'];

        $handler->process(true);
    }

    public function onBeforeRender(StiReportEventArgs $args)
    {

    }

    public function onPrepareVariables(StiVariablesEventArgs $args)
    {
        // You can set the values of the report variables, the value types must match the original types
        // If the variable contained an expression, the already calculated value will be passed
        // The new values will be passed to the report generator
        /*
        $args->variables['VariableString']->value = 'Value from Server-Side';
        $args->variables['VariableDateTime']->value = '2020-01-31 22:00:00';

        $args->variables['VariableStringRange']->value->from = 'Aaa';
        $args->variables['VariableStringRange']->value->to = 'Zzz';

        $args->variables['VariableStringList']->value[0] = 'Test';
        $args->variables['VariableStringList']->value = ['1', '2', '2'];

        $args->variables['NewVariable'] = ['value' => 'New Value'];
        */

        // Changing variables with the required values
        if (count($args->variables) > 0) {
            $args->variables['Name']->value = 'Maria';
            $args->variables['Surname']->value = 'Anders';
            $args->variables['Email']->value = 'm.anders@stimulsoft.com';
            $args->variables['Address']->value = 'Obere Str. 57, Berlin';
            $args->variables['Sex']->value = false;
            $args->variables['BirthDay']->value = '1982-03-20 00:00:00';
        }
    }

    // In this event, it is possible to handle the data request, and replace the connection parameters
    public function onBeginProcessData(StiDataEventArgs $args)
    {
        // You can change the connection string
        // This example uses the 'Northwind' SQL database, it is located in the 'Data' folder
        // You need to import it and correct the connection string to your database
        if ($args->connection == 'MyConnectionName')
            $args->connectionString = 'Server=localhost; Database=northwind; UserId=root; Pwd=;';

        // You can change the SQL query
        if ($args->dataSource == 'MyDataSource')
            $args->queryString = 'SELECT * FROM MyTable';

        // You can change the SQL query parameters with the required values
        // For example: SELECT * FROM @Parameter1 WHERE Id = @Parameter2 AND Date > @Parameter3
        if ($args->dataSource == 'MyDataSourceWithParams') {
            $args->parameters['Parameter1']->value = 'TableName';
            $args->parameters['Parameter2']->value = 10;
            $args->parameters['Parameter3']->value = '2019-01-20';
        }

        // You can change the connection string.
        /*
        if ($args->connection == 'MyConnectionName')
            $args->connectionString = 'Server=localhost;Database=test;uid=root;password=******;';
        */

        // You can change the SQL query.
        /*
        if ($args->dataSource == 'MyDataSource')
            $args->queryString = 'SELECT * FROM MyTable';
        */

        // You can change the SQL query parameters with the required values.
        // For example: SELECT * FROM @Parameter1 WHERE Id = @Parameter2 AND Date > @Parameter3
        /*
        if ($args->dataSource == 'MyDataSourceWithParams') {
            $args->parameters['Parameter1']->value = 'TableName';
            $args->parameters['Parameter2']->value = 10;
            $args->parameters['Parameter3']->value = '2019-01-20';
        }
        */

        // Values for 'SimpleListSQLParameters.mrt' report template.
        if ($args->dataSource == 'customers' && count($args->parameters) > 0) {
            $args->parameters['Country']->value = 'Germany';
        }

        // If required, it is possible to show a message about success or some error
        //return StiResult::getSuccess('Connection to the server was successful.');
        // You can send an error message.
        //return StiResult::getError('An error occurred while connecting to the server.');

        //$args->parameters['Country']->value = 1234;
    }

    public function onEndProcessData(StiDataEventArgs $args)
    {

    }

    public function onPrintReport(StiPrintEventArgs $args)
    {

    }

    public function onBeginExportReport(StiExportEventArgs $args)
    {

    }

    public function onEndExportReport(StiExportEventArgs $args)
    {
        // Getting the file name with the extension
        $reportName = $args->fileName;
        if (substr($reportName, -strlen($args->fileExtension) - 1) !== '.' . $args->fileExtension)
            $reportName .= '.' . $args->fileExtension;

        // Saving the exported file in the 'reports' folder
        $reportPath = "reports/$reportName";
        file_put_contents($reportPath, base64_decode($args->data));

        // If required, it is possible to show a message about success or some error
        //return StiResult::getSuccess("The exported report has been successfully saved to '$reportPath' file.");
        //return StiResult::getError('An error occurred while exporting the report.');
    }

    public function onEmailReport(StiEmailEventArgs $args)
    {
        // Defining the required options for sending (host, login, password), they will not be passed to the client side
        $args->settings->from = 'mail.sender@stimulsoft.com';
        $args->settings->host = 'smtp.stimulsoft.com';
        $args->settings->login = '********';
        $args->settings->password = '********';

        // These parameters are optional
        //$args->settings->name = 'John Smith';
        //$args->settings->port = 465;
        //$args->settings->secure = 'ssl';
        //$args->settings->cc[] = 'copy1@stimulsoft.com';
        //$args->settings->bcc[] = 'copy2@stimulsoft.com';
        //$args->settings->bcc[] = 'copy3@stimulsoft.com John Smith';

        // You can return a message about the successful sending of an email
        // If the message is not required, do not return the result
        // If an error occurred while sending an email, a message from the email sending module will be displayed
        return StiResult::getSuccess('The Email has been sent successfully.');
    }

    public function onCreateReport(StiReportEventArgs $args)
    {
        // You can load a new report and send it to the designer.
        //$args->report = file_get_contents('reports/SimpleList.mrt');
    }

    public function onSaveReport(StiReportEventArgs $args)
    {
        // Getting the correct file name of the report template
        $reportFileName = strlen($args->fileName) > 0 ? $args->fileName : 'Report.mrt';
        if (strlen($reportFileName) < 5 || substr($reportFileName, -4) !== '.mrt')
            $reportFileName .= '.mrt';

        // Saving the report file in the 'reports' folder on the server-side
        $reportPath = "reports/$reportFileName";
        $result = file_put_contents($reportPath, $args->getReportJson());

        // If required, it is possible to show a message about success or some error
        if ($result === false)
            return StiResult::getError('An error occurred while saving the report file on the server side.');
        return StiResult::getSuccess("The report has been successfully saved to '$reportPath' file.");
        //return StiResult::getSuccess();
    }

    public function onSaveAsReport(StiReportEventArgs $args)
    {
        // This event works the same as the 'onSaveReport' event.
    }
}
