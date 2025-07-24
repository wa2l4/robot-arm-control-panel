## Robot Arm Control Panel
This project provides a simple web interface to control a 6-motor robot arm.

Users can adjust each motor’s angle using sliders, save different arm positions ("poses") to a MySQL database, load and delete saved poses, and send the latest pose to the robot arm for execution.

The interface uses HTML, CSS, and JavaScript for the frontend, and PHP with MySQL for backend database handling.

## Features
Control six motors with sliders.

Save, load, and delete saved poses.

Run the latest saved pose on the robot arm.

Dynamic updates without page reloads using Fetch API.

## Setup Instructions
Create a MySQL database named robot_arm with a table robot_arm_status to store motor positions and status.

Upload all PHP files to your web server.

Update database connection settings in PHP files if necessary.

Open index.php in your browser and start controlling the robot arm.

## Project Files
- index.php – Main interface.
- save_pose.php – Saves a new pose to the database.
- load_pose.php – Loads a saved pose.
- remove_pose.php – Deletes a pose.
- get_run_pose.php – Runs the latest saved pose.
- update_status.php – Resets pose statuses.
