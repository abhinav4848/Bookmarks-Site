# Bookmarks Site
A collection of knowledgeable websites.

## Html page usage
The original format was just a list of bullet points.
The next one is a searchable as you type along.
No outside dependencies have been used.

## PHP + SQLite usage
Upload the site to your server.
Then visit `setup.php` in your browser. It'll create a database with 2 tables
- One for category, 
- Another for the individual websites + a link (foreign id) to the category.

It then imports the `bookmarks.json` file into this database. 
After this, you can visit `index.php` from the browser. 
At the bottom of this page, there's an export option which uses `export.php` to dump the entire database in json format. Good Stuff.

### Note
Life was made simple for this project by using ChatGpt4.1
I made sure none of the code it used was above my understanding. 