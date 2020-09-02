<?php

require 'vendor/autoload.php';

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\Core\ExponentialBackoff;

$projectId = getenv("PROJECTID");
$datasetId = getenv("DATASETID");
$gcsUri    = getenv("GCSURI");
$tableId   = getenv("TABLEID");

$bigQuery = new BigQueryClient([
    'projectId' => $projectId,
]);
$table = $bigQuery->dataset($datasetId)->table($tableId);

// create the import job
$loadConfig = $table->loadFromStorage($gcsUri)->sourceFormat('NEWLINE_DELIMITED_JSON')->WriteDisposition('WRITE_TRUNCATE');
$job = $table->runJob($loadConfig);

// poll the job until it is complete
$backoff = new ExponentialBackoff(10);
$backoff->execute(function () use ($job) {
    print('Waiting for job to complete' . PHP_EOL);
    $job->reload();
    if (!$job->isComplete()) {
        throw new Exception('Job has not yet completed', 500);
    }
});

// check if the job has errors
if (isset($job->info()['status']['errorResult'])) {
    $error = $job->info()['status']['errorResult']['message'];
    printf('Error running job: %s' . PHP_EOL, $error);
} else {
    print('Data imported successfully' . PHP_EOL);
}

?>