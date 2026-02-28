# Web-Based Data Dashboard & API Integration

## Overview
A centralized interface for visualizing sales, server performance, user demographics, and real-time currency exchange rates. This application is designed to retrieve, process, and visualize data from internal and external sources. 

**Context:** Cloud Technologies Coursework

## Features
* **Data Visualization:** Four distinct interactive charts displaying Sales, Browser Share, Server Load, and Device Usage.
* **External Integration:** Real-time fetching of USD and CHF exchange rates against PLN via the National Bank of Poland (NBP) API.
* **Architecture:** Separation of concerns utilizing a REST-style API layer for internal data distribution.
* **Testing:** Manual verification of data integrity via a dedicated test script (`test.php`) that re-fetches data from all internal APIs.

## Technology Stack
* **Backend:** PHP 8.1 running on an Apache server.
* **Database:** MySQL hosted on AwardSpace (Remote connection).
* **Frontend:** HTML5, Bootstrap 5.3.3 for responsive layout.
* **Visualization:** Plotly.js for rendering dynamic charts.
* **Containerization:** Docker for environment consistency.

## Database Design
The relational database relies on four primary tables:
1. `sales`: Stores monthly financial performance.
2. `browsers`: Tracks market share percentages of web browsers.
3. `server_performance`: Monitors CPU load across different servers.
4. `devices`: Categorizes user access by device type (Desktop, Mobile, Tablet).

## API Endpoints
The application exposes data through specific PHP endpoints acting as a REST API:
* `api_sales.php`: Returns JSON formatted sales data.
* `api_users.php`: Returns browser statistics.
* `api_performance.php`: Returns server load metrics.
* `api_devices.php`: Returns device usage statistics.

## Deployment
The environment is containerized using Docker. Deployment requires building the image from the provided `Dockerfile`, which configures a `php:8.1-apache` environment, sets the server name, copies the repository files to the web root, and exposes port 80.
