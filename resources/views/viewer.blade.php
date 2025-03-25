<?php

use Stimulsoft\Report\StiReport;
use Stimulsoft\Viewer\StiViewer;


// Creating a viewer object
$viewer = new StiViewer();

// Redirect events to the handler controller
// It is also necessary to specify which component events will be processed
$viewer->handler->url = "/handler";
$viewer->onPrepareVariables = true;

// Creating a report object
$report = new StiReport();

// Loading a report by URL
// This method does not load the report object on the server side, it only generates the necessary JavaScript code
// The report will be loaded into a JavaScript object on the client side
$report->loadFile("reports/SimpleList.mrt");
//$report->loadFile("reports/Variables.mrt");
//$report->loadFile("reports/SimpleListSQL.mrt");
//$report->loadFile("reports/SimpleListSQLParameters.mrt");

// Assigning a report object to the viewer
$viewer->report = $report;

// Displaying the visual part of the viewer as a prepared HTML page
$viewer->printHtml();
