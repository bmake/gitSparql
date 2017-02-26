# gitSparql

Update data in a Triple store based on data stored in a github repository.

## How to use

1. Open webhook.php to generate config.php with secret
2. [Create a new webhook](https://developer.github.com/webhooks/creating/)
3. Add payload url with parameters
  - secret: Secret as configured in application (config.php)
  - endpoint: Sparql Endpoint to update data
  - data: path to files with data (for multiple files use array, e.g. &data[]=FILE1&&data[]=FILE2
  - Example `webhook.php?secret=XYZSDF&endpoint=http://fuseki/dataset/data?default&data[]=FILE1&data[]=FILE2`

## Hints
- config.php is automatically generated at first start. It contains the automatic generated secret. 
- Remember to check permissions `sudo chown www-data:www-data -R gitSparql/`
