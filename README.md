# Stats viewing app
### A basic stats viewing application to analyze monetization events, stored in a database and retrieved via specified routes.

## Installation
Clone this repository.

- Run the following command to install dependencies: `composer install`
- Run the migrations and seeders to set up the database schema: `php artisan migrate --seed`
- The project uses a pre-seeded SQLite database by default. To use MySQL:
    - Update the .env configuration with your MySQL credentials.
    - Run the migrations and seeders as specified above.
- Start the application with: `php artisan serve`


## Database Schema
The database schema has been normalized to 3rd normal form and consists of the following tables:

- campaigns: Stores unique campaigns identified by `utm_campaign`.
- terms: Stores unique terms identified by `utm_term`.
- stats: Contains individual monetization events with a `term_id` and `campaign_id` referencing the `terms` and `campaigns` tables, respectively. It also includes a timestamp and revenue field to enable hourly breakdowns.

This structure ensures that `utm_campaign` and `utm_term` values are stored only once in the database, facilitating efficient queries and normalization.

## CSV Import Command
To import data from a CSV file, use the custom command ImportStatsCommand as follows:
`php artisan app:import-stats {filename}`

- Description: This command accepts a CSV filename as a parameter and imports the data into the database.
- Validation: Rows without a value for utm_campaign or utm_term are skipped.
- Example: Import a file named stats_2024_03_31.csv: `php artisan app:import-stats stats_2024_03_31.csv`

## Routes
The application provides three routes to display statistics. Below are the routes and descriptions for each.

### Route 1: Campaign List (Home Route)
- URL: `/`
- Description: Displays a list of all campaigns, with total revenue aggregated by each `utm_campaign`.
- Controller Method: `CampaignController@index`
- Link: Each campaign row includes a link to view the detailed breakdown for that specific campaign.

### Route 2: Revenue by Date and Hour for a Campaign
- URL: `/campaigns/{campaign}`
- Description: Displays detailed revenue data for a single campaign, broken down by date and hour.
- Controller Method: `CampaignController@show`
- Parameters: `{campaign}` - The ID or slug of the specific campaign.

### Route 3: Revenue by Publisher (utm_term) for a Campaign
- URL: `/campaigns/{campaign}/publishers`
- Description: Displays revenue for a single campaign, broken down by each `utm_term`.
- Controller Method: `CampaignController@publishers`
- Parameters: `{campaign}` - The ID or slug of the specific campaign


## Laravel Version
- This project is built with Laravel 11, taking advantage of its modern features and improvements.
