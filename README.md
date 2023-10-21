# PHP_2023

## Example
## load data
- `php index.php -l data/data.json`
## add event to Redis
- `php index.php -a '{ "priority": 1000, "conditions": { "param1": 1}, "event": "::event1::"}'`
## get event 
- `php index.php -g '{"param1": 3,"param2":1}'`
- `php index.php -g '{"param1": 3}'`
- `php index.php -g '{"param3": 3}'`