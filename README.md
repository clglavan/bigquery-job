## vulns-ossp
Part of the sample implementation at https://clglavan.github.io/nvd-scrapper/

# bigquery-job
Launch a container that starts an import job to bq from gcs

environment
- GCSURI: path of the file in the bucket
- TABLEID: dataset table 
- PROJECTID: get from gcp
- DATASETID: get from gcp
- GOOGLE_APPLICATION_CREDENTIALS: path inside container where auth key is mounted

```dockerfile
docker run -e PROJECTID="{project_id}" \
-e DATASETID="{dataset_id}" \
-e GCSURI="{gcs_uri}" \
-e TABLEID="{table_id}" \
-e GOOGLE_APPLICATION_CREDENTIALS=/google/key.json \
-v $(pwd):/google/ \
--rm clglavan/bigquery-job
```

