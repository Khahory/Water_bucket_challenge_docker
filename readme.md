# Water bucket challenge
Build an application that solves the Water Jug Riddle for dynamic inputs (X, Y, Z). The
simulation should have a UI (if SPA) to display state changes for each state for each jug
(Empty, Full or Partially Full).

You have an X-gallon and a Y-gallon jug that you can fill from a lake. (Assume lake has unlimited amount
of water.) By using only an X-gallon and Y-gallon jug (no third jug), measure Z gallons of water.

## Download
Docker: https://www.docker.com/

## Installation
1. Clone the repository
2. Run the command `docker compose up` in the root folder of the project
3. Go to http://localhost:3000/ in your browser
4. Enjoy

## About the docker-compose
1. The docker-compose file contains 2 services
   - Backend
   - Frontend
2. The backend service is a PHP application that uses the CodeIgniter framework
3. The frontend service is a Node application that uses the React framework

## Images used
1. Node: 19-alpine
2. PHP: 7.4.33-apache