# Backend Engineer / Software Engineer Home Assignment
---
The assignment details provided by Bunq are as below. 🌈

The purpose of this project is to create a simple chat application backend in PHP. A user should be able to send a text message to another user, and a user should be able to get the messages sent to them and see the author of those messages.

Data has to be stored in an SQLite database, and all the communications have to be over a RESTful JSON API. A GUI, user registration, and user login are not needed, but the users should be identified by some token, username, or ID in the HTTP messages and the database. Slim microframework has to be used for the project.

## Technologies
---
#### Slim
Slim microframework is used to develop this project.
#### SQLite
SQLite is used to store all the data.
#### Docker
The application runs inside a Docker Linux container. Docker sets up everything needed for the application by updating the composer and running the database's init script every time the container starts. It also automatically starts the application on the container start. This isolates the application from the host OS and makes deployment easier.
#### Composer
Composer is an application-level package manager for PHP. It is used to include dependencies of the project. See `composer.json`.
#### Monolog
Monolog library is used to generate and show different types of logs of the application.
#### PHPUnit
PHPUnit is a programmer-oriented testing framework for PHP. It is used to develop tests for the application.
#### Faker
Faker library is used to generate mock data for the tests.
#### PHP
PHP version is 7.4.11.

## Architecture
---
The application is developed using onion architecture. It is done to lower coupling and make codes cleaner. The application consists of three main layers, the Service layer, wrapped by the Repository layer, and both wrapped by the Network layer. There is also a Test layer wrapping all other layers.
#### Service Layer
This is where data models, value objects and main logic of the application exists. This layer is developed based on Phava framework.

This layer consists of models, objects, and factories. Models are the data models used in the application. Objects are the data objects as described in the Phava framework. Factories are the classes used to make creating models easier.
#### Repository Layer
Everything related to databases is done in this layer. Connecting to databases, querying databases, creating data models based on data stored in databases, all done here.

This layer has repositories and helpers. Repositories are mainly based on the service layer and are used to fetch required data from databases to create a model or put data from a model into a database. Helpers are used to helping with things related to databases, like establishing a connection with a database.
#### Network Layer
The network layer is where everything related to requests and responses is done. Reading data from requests and preparing and sending responses are done here.
This layer consists of controllers, factories, and helpers. Controllers are where requests are received, and responses are sent, headers and body of the requests are extracted here, and status code, headers, and contents of responses are decided here.

This layer consists of controllers, factories, and helpers. Controllers are where requests are received, and responses are sent, headers and body of the requests are extracted here, and status code, headers, and contents of responses are decided here. Factories are used to generate things related to requests and responses. There are two main factories at the moment, JSON factory, which creates JSON data based on application models, and response factory, which generates responses based on provided parameters. Helpers are used for doing other things related to networking. Currently, only one helper exists, which is used to authenticate users.

## Database
---
The SQLite databases for this project are located in the `database` directory. `ChatDB.db` and `TestChatDB.db` both have to be present in this directory for the application to work. There are two tables in the database, 'User' and 'Message'. The databases are being reinitialized every time the Docker container starts. Look at `init.sql` for more details about the database.

There are three users in the database, you will need these users tokens and usernames to use the application. These users are:

| USERNAME | NAME | SURNAME | TOKEN |
| ------ | ------ | ------ | ------ |
| puyayavari | Pouya | Yavari | c452116e-deea-4f42-be5d-01646a6f8980 |
| oli | Oliver | Sinclare | 4e77356e-fdc6-45b8-be95-c8fb669cabad |
| joe | Joe | Biden | ecf7ce1b-a4dd-4424-ae99-8df2e4b5bc56 |

> **IMPORTANT NOTE**: Tokens are statically defined in the database because user registration and login are out of the scope of the assignment. Services like Auth0 should be used to generate tokens after user registration and login are developed.

## Tests
---
PHPUnit is used to test the application. All tests are located inside the `test` directory. There are basic unit and entegration tests.  Look at `phpunit.xml` for more detail on tests.

You can run tests by arraching to container's shell and running `RunTests` script in the projects root.

## Deployment
---
You need Docker with Linux containers backend to be able to run the application. 

Open your terminal and navigate to projects root directory, run command `docker-compose build` to build the container, then run `docker-compose up` to run the application in a container. Everything should work and the system is running on `http://localhost:8000`.

## Manuals
---
#### Headers
##### Authorization
The client should include the token of the user it wants to authenticate as a **standard Bearer Token**. This can be done from the 'Authorization' tab of the Postman request. Invalid authentication returns a response with HTTP status code 401 (Unauthorized).
##### Content-Type
The `Content-Type` header should be set to `application/json` for every post and put request.
##### Page-Number and Page-Size
The application has pagination for GET requests sent to Messages endpoint. You have to include `Page-Number` and `Page-Size` headers for the requests sent to these endpoints. These headers have to be larger than zero integer values. Any request missing these headers or any invalid values for these headers will result in an HTTP response with a 400 status code (Bad Request).

#### Endpoints
##### Sending Message
You can use this url to send messages:
| METHOD | URL |
| ------ | ------ |
| `POST` | http://localhost:8000/api/Messages/{username} |
###### URL element
- *usename* : usename of the user you want to send message to.

###### Request Body
The request body contains the message, and if it is a response to another message, it has to contain the id of that message.

- *Message* : This field is mandatory, missing, or empty message will result in an HTTP response with 400 status code. (Bad Request)
- *ResponseToMessage* : This field is optional. It means that the given message is a response to the message with the given id. If no message with the given id exists or this field has an invalid value, it won't affect the response, but it won't be written to the database.

Example body : `
{
    "Message":"hey!",
    "ResponseToMessage":4
}`

##### Fetching Message
There are two endpoints to fetch messages. One endpoint to fetch the messages of the user from all users, and one endpoint to fetch the messages of the user from a specific user. These endpoints are:
| METHOD | URL |
| ------ | ------ |
| `GET` | http://localhost:8000/api/Messages |
| `GET` | http://localhost:8000/api/Messages/{username} |

###### URL element
- *usename* : usename of the user you want to fetch message from.

A successful request will return a response with a 200 (OK) status code, containing an array of messages. Each returned message consists of:

- *Id* : An integer value. This is the id of the message
- *Sender* : A string value. Username of the sender
- *Receiver* : A string value. Username of the receiver
- *Body* : A string value. Contents of the message
- *ResponseTo* : A string value. Contents of the message current message is responding to
- *Time* : A string value. Date and time the message was received by the backend in YYYY-mm-dd HH:ii:ss format

Example response body : `[
    {
        "Id": 2,
        "Sender": "puyayavari",
        "Receiver": "oli",
        "Body": "Hello Oli",
        "ResponseTo": "Hello",
        "Time": "2020-11-16 17:25:58"
    }
]`