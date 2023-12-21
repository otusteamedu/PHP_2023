# Setup and Initialization Instructions

To build the containers and execute the database initialization script, which creates the DDL schema for the cinema management system, run the following command:

\`\`\`bash
sudo sh ./init-db.sh
\`\`\`

This will start all required Docker services and automatically apply the database schema to PostgreSQL.

# Homework Assignment

## EAV Model

### Objective:

Practice writing complex SQL queries over the schema to check the correctness of the structure.
Enhance the schema with flexible storage of various types of values without violating normalization.

### Description/Step-by-Step Instructions for Completing the Homework Assignment:

Design EAV storage for a cinema database
4 tables: movies, attributes, attribute types, values.
Types of attributes and corresponding attributes (for example):

- reviews (text values) - critics' reviews, feedback from an unknown film academy...
- award (replaced by an image when printing banners and tickets, boolean value) - Oscar, Nika...
- "important dates" (when printing - attribute name and date value, type date) - world premiere, premiere in the Russian Federation...
- service dates (used in planning, type date) - date ticket sales start, when to launch TV advertising...

View assembly of service data in the form:
- movie, tasks current for today, tasks current for 20 days ahead

View assembly of marketing data in the form (three columns):
- movie, attribute type, attribute, value (output value as text)

### Evaluation Criteria:

1. All permissible data types are considered;
2. The specifics of storage and subsequent use of float data are considered;
3. The EAV schema is equipped with indexes.
