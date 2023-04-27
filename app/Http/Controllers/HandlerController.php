<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Stimulsoft\StiDataEventArgs;
use Stimulsoft\StiExportEventArgs;
use Stimulsoft\StiHandler;
use Stimulsoft\StiReportEventArgs;
use Stimulsoft\StiResult;
use Stimulsoft\StiVariablesEventArgs;

class HandlerController extends BaseController
{
    public function process()
    {
        $handler = new StiHandler();
        $handler->onPrepareVariables = array($this, 'onPrepareVariables');
        $handler->onBeginProcessData = array($this, 'onBeginProcessData');
        $handler->onEndProcessData = array($this, 'onEndProcessData');
        $handler->onPrintReport = array($this, 'onPrintReport');
        $handler->onBeginExportReport = array($this, 'onBeginExportReport');
        $handler->onEndExportReport = array($this, 'onEndExportReport');
        $handler->onEmailReport = array($this, 'onEmailReport');
        $handler->onCreateReport = array($this, 'onCreateReport');
        $handler->onSaveReport = array($this, 'onSaveReport');
        $handler->onSaveAsReport = array($this, 'onSaveAsReport');

        $handler->process();
    }

    public function onPrepareVariables(StiVariablesEventArgs $args): StiResult
    {
        // You can change the values of the variables used in the report.
        // The new values will be passed to the report generator.
        /*
        $args->variables['VariableString']->value = 'Value from Server-Side';
        $args->variables['VariableDateTime']->value = '2020-01-31 22:00:00';

        $args->variables['VariableStringRange']->value->from = 'Aaa';
        $args->variables['VariableStringRange']->value->to = 'Zzz';

        $args->variables['VariableStringList']->value[0] = 'Test';
        $args->variables['VariableStringList']->value = ['1', '2', '2'];

        $args->variables['NewVariable'] = ['value' => 'New Value'];
        */

        // Values for 'Variables.mrt' report template.
        if (count($args->variables) > 0) {
            $args->variables['Name']->value = 'Maria';
            $args->variables['Surname']->value = 'Anders';
            $args->variables['Email']->value = 'm.anders@stimulsoft.com';
            $args->variables['Address']->value = 'Obere Str. 57, Berlin';
            $args->variables['Sex']->value = false;
            $args->variables['BirthDay']->value = '1982-03-20 00:00:00';
        }

        return StiResult::success();
    }

    public function onBeginProcessData(StiDataEventArgs $args): StiResult
    {
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
        if ($args->dataSource == 'customers') {
            $args->parameters['Country']->value = "Germany";
        }

        // You can send a successful result.
        return StiResult::success();
        // You can send an informational message.
        //return StiResult::success('Some warning or other useful information.');
        // You can send an error message.
        //return StiResult::error('Message about any connection error.');
    }

    public function onEndProcessData(StiDataEventArgs $args): StiResult
    {
        return StiResult::success();
    }

    public function onPrintReport(StiExportEventArgs $args): StiResult
    {
        return StiResult::success();
    }

    public function onBeginExportReport(StiExportEventArgs $args): StiResult
    {
        return StiResult::success();
    }

    public function onEndExportReport(StiExportEventArgs $args): StiResult
    {
        // Getting the file name with the extension.
        $reportName = $args->fileName . '.' . $args->fileExtension;

        // By default, the exported file is saved to the 'reports' folder.
        // You can change this behavior if required.
        file_put_contents('reports/' . $reportName, base64_decode($args->data));

        //return StiResult::success();
        return StiResult::success("The exported report is saved successfully as $reportName");
        //return StiResult::error('An error occurred while exporting the report.');
    }

    public function onEmailReport(StiExportEventArgs $args): StiResult
    {
        // These parameters will be used when sending the report by email. You must set the correct values.
        $args->emailSettings->from = '*****@gmail.com';
        $args->emailSettings->host = 'smtp.google.com';
        $args->emailSettings->login = '*****';
        $args->emailSettings->password = '*****';

        // These parameters are optional.
        //$args->emailSettings->name = 'John Smith';
        //$args->emailSettings->port = 465;
        //$args->emailSettings->cc[] = 'copy1@gmail.com';
        //$args->emailSettings->bcc[] = 'copy2@gmail.com';
        //$args->emailSettings->bcc[] = 'copy3@gmail.com John Smith';

        return StiResult::success('Email sent successfully.');
    }

    public function onCreateReport(StiReportEventArgs $args): StiResult
    {
        // You can load a new report and send it to the designer.
        //$args->report = file_get_contents('reports/SimpleList.mrt');

        return StiResult::success();
    }

    public function onSaveReport(StiReportEventArgs $args): StiResult
    {
        // Getting the correct file name of the report template.
        $reportFileName = strlen($args->fileName) > 0 ? $args->fileName : 'Report.mrt';
        if (strlen($reportFileName) < 5 || substr($reportFileName, -4) !== '.mrt')
            $reportFileName .= '.mrt';

        // For example, you can save a report to the 'reports' folder on the server-side.
        file_put_contents('reports/' . $reportFileName, $args->reportJson);

        //return StiResult::success();
        return StiResult::success('Report file saved successfully as ' . $args->fileName);
        //return StiResult::error('An error occurred while saving the report file on the server side.');
    }

    public function onSaveAsReport(StiReportEventArgs $args): StiResult
    {
        // This event works the same as the 'onSaveReport' event.
        return StiResult::success();
    }
}
