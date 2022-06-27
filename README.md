# database-spread-cli

A cli client to consume the database spread.

## To start the use

Just clone the `.env.example` file to a file called `.env` and add the database credentials (AND KEEP THIS DATA SAFE!). This project already have a `.gitignore` to do not make versions of the `.env` file, which may have sensitive data.

## Usage

There are the following way to use this utility:

* get all tables from a database

```
php src/entry.php get_tables
```
Prints table from the database.

---

* get tables with its sizes

```
php src/entry.php get_tables_with_sizes
```

---

Get all fields from all databases, printing to the terminal:

```
php src/entry.php get_fields
```
