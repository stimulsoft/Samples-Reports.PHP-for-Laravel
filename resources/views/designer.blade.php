<?php

use Stimulsoft\Designer\StiDesigner;
use Stimulsoft\Report\StiReport;


// Creating a designer object
$designer = new StiDesigner();

// Redirect events to the handler controller
// It is also necessary to specify which component events will be processed
$designer->handler->url = "/handler";
$designer->onSaveReport = true;

// Creating a report object
$report = new StiReport();

// Loading a report by URL
// This method does not load the report object on the server side, it only generates the necessary JavaScript code
// The report will be loaded into a JavaScript object on the client side
$report->loadFile("reports/SimpleList.mrt");

// Assigning a report object to the designer
$designer->report = $report;

// Displaying the visual part of the designer as a prepared HTML page
$designer->printHtml();
