# gitSparql

Update data in SPARQL-Endpoint with Webhook 

## Parameters
- secret: Secret as configured in application
- endpoint: Sparql Endpoint to update data
- data: path to files with data (for multiple files use array, e.g. &data[]=FILE1&&data[]=FILE2


```
webhook.php?secret=XYZSDF&endpoint=http://fuseki/dataset/data?default&data[]=FILE1&data[]=FILE2
```