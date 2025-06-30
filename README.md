# Webnode Entry Task

This repository contains my solution for the Webnode entry task.

---

## Project Description

The goal of this task was to build a simple REST API endpoint for retrieving order data. During development, my main focus was on keeping the code clean and readable.

---

## Version History

I used Git for version control. The commit history clearly separates the base framework files from my own files, making it easy to track the development progress and understand the work process.

---

## Development Process

- Project initialization  
- Deciding if I want to use a framework & adding some Symfony components  
- Implementing key features according to the task  
- Testing and debugging
- Building it into a Docker app and ensuring it is easy to run  
- Finalizing and documenting  

---

## Feedback on the Task

- The task was clearly described and allowed me to showcase my approach and skills.  
- I appreciated the requirement to keep a clean commit history, which encouraged incremental and disciplined work.  
- Time spent: approximately **~5 hours**  
- Overall, I found the task to be a good opportunity to demonstrate my abilities.

---

## How to Run

Clone the repository and run the bash script `run-app.sh`. This script sets up the Docker container running the application and initializes the database with the required tables and data.

---

## Notes & Possible Improvements

The application and endpoints are designed using PHP 8.1+ features such as enums and constructor property promotion. In older PHP versions, enums would be replaced with constants inside entities, and properties would be declared inside the class instead of the constructor, since constructor property promotion is not available before PHP 8.0.

Here are some improvements I considered but couldn't implement due to time constraints:

- Adding some basic authentication to handle typical REST API response codes for unauthorized access.  
- Implementing pagination and sorting of results via query parameters
- As I mentioned in the code - having the statuses saved in database and then have them as a foreign key would make it a bit cleaner too (way easier scalability)
- The same goes for currencies, I think having them in DB would be better too, but since this is an entry task I decided to go the quicker way and save them as ISO codes
- Using PHPStan for static code analysis and maybe using something like https://github.com/easy-coding-standard/easy-coding-standard for code style checking

---

## Contact

If you have any questions or feedback, feel free to reach out.

---
