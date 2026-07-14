-- --------------------------------------------------------
-- Database: school_db
-- --------------------------------------------------------

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    class VARCHAR(20) NOT NULL,
    semester VARCHAR(10)
);

CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(50) NOT NULL
);

CREATE TABLE marks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    marks_obtained DECIMAL(5,2) NOT NULL,
    max_marks DECIMAL(5,2) DEFAULT 100,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

CREATE TABLE chatbot_qa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    keywords VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL
);

-- Insert School Data for Chatbot
INSERT INTO chatbot_qa (keywords, answer) VALUES
('teachers, faculty, staff, sir, madam', 'RM Model School has 35 dedicated and highly qualified teachers.'),
('students, pupil, children, kids, learner', 'RM Model School has 520 enrolled students across all classes.'),
('rooms, classroom, lab, library, hall', 'RM Model School has 20 smart classrooms, 1 computer lab, 1 science lab, and a large library.'),
('principal, headmaster, director, head', 'The Principal of RM Model School is Mr. S. K. Roy (M.Sc, B.Ed).'),
('address, location, situated, where', 'RM Model School is located at Buniadpur, Dakshin Dinajpur, West Bengal, 733121.'),
('contact, phone, mobile, call, number', 'You can contact RM Model School at 9064651620 or email: info@rmmodelschool.edu.'),
('about, school, information, details', 'RM Model School is a premier educational institution in Buniadpur, dedicated to holistic education since 2005.'),
('timing, time, shift, morning', 'School timing is from 10:00 AM to 4:00 PM (Monday to Friday). Saturdays are half-day.');

-- Insert Sample Subjects
INSERT INTO subjects (subject_name) VALUES ('Mathematics'), ('English'), ('Science'), ('Computer Science'), ('Bengali');

-- Insert Sample Students (so your dashboard looks full)
INSERT INTO students (name, class, semester) VALUES 
('Rahul Sharma', '10', '1st'),
('Priya Das', '10', '1st'),
('Amit Kumar', '10', '1st'),
('Sneha Roy', '12', '1st'),
('Vikram Singh', '12', '1st');

-- Insert Sample Marks
INSERT INTO marks (student_id, subject_id, marks_obtained) VALUES
(1, 1, 85), (1, 2, 78), (1, 3, 92), (1, 4, 88), (1, 5, 76),
(2, 1, 65), (2, 2, 82), (2, 3, 70), (2, 4, 91), (2, 5, 60),
(3, 1, 95), (3, 2, 88), (3, 3, 94), (3, 4, 97), (3, 5, 82),
(4, 1, 72), (4, 2, 69), (4, 3, 65), (4, 4, 78), (4, 5, 70),
(5, 1, 88), (5, 2, 92), (5, 3, 85), (5, 4, 90), (5, 5, 84);