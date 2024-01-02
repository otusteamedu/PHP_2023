## Library Project Description

This project involves populating an Elasticsearch index with documents related to a library. The documents are uploaded using the Elasticsearch `_bulk` command.

### Running the Application

To view the results of the project, follow these steps:

1. Start the Docker containers.
2. Access the PHP container using the command: `docker exec -it php-console /bin/bash`.
3. Inside the container, execute the PHP script with the command: `php index.php рыЦори поррручика`.

#### Expected Output

The script will output an array of historical novels matching the criteria ("рыЦори", "поррручика") with their respective scores. The output includes details like title, SKU, category, price, stock, and the relevance score (`_score`).
