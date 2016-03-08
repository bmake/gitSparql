# gitSparql

Update data in SPARQL-Endpoint with Webhook.

config.php is automatically generated at first start. It contains the automatic generated secret. 

## Parameters
- secret: Secret as configured in application
- endpoint: Sparql Endpoint to update data
- data: path to files with data (for multiple files use array, e.g. &data[]=FILE1&&data[]=FILE2


```
webhook.php?secret=XYZSDF&endpoint=http://fuseki/dataset/data?default&data[]=FILE1&data[]=FILE2
```


## Misc

Remember to check permissions 

```
sudo chown www-data:www-data -R gitSparql/
```