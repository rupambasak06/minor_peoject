<?php
// chatbot_api.php - Extended static answers with synonyms
header('Content-Type: application/json');

$input = isset($_POST['message']) ? trim($_POST['message']) : '';
if (empty($input)) {
    echo json_encode(['reply' => 'Please ask a question.']);
    exit;
}

$answers = [
    // Teachers
    'teachers' => 'RM Model School has 35 dedicated and highly qualified teachers, including subject experts and co-curricular instructors.',
    'teacher' => 'RM Model School has 35 dedicated and highly qualified teachers, including subject experts and co-curricular instructors.',
    'faculty' => 'RM Model School has 35 dedicated and highly qualified teachers, including subject experts and co-curricular instructors.',
    'staff' => 'RM Model School has 35 dedicated and highly qualified teachers, plus 10 support staff members.',

    // Students
    'students' => 'RM Model School has 520 enrolled students across classes 1 to 12.',
    'student' => 'RM Model School has 520 enrolled students across classes 1 to 12.',
    'pupil' => 'RM Model School has 520 enrolled students across classes 1 to 12.',
    'children' => 'RM Model School has 520 enrolled children from diverse backgrounds.',

    // Classrooms / Infrastructure
    'rooms' => 'RM Model School has 20 smart classrooms, 1 computer lab, 1 science lab, a library, and a large auditorium.',
    'classroom' => 'RM Model School has 20 smart classrooms equipped with digital boards and projectors.',
    'lab' => 'We have a fully equipped computer lab with 30 PCs and a separate science lab for physics, chemistry, and biology experiments.',
    'library' => 'Our library has over 5,000 books, magazines, and digital resources. Students can borrow books every week.',
    'auditorium' => 'The school has a 300-seat auditorium for events, assemblies, and cultural programs.',

    // Principal
    'principal' => 'The Principal of RM Model School is Mr. S. K. Roy (M.Sc, B.Ed) with 20 years of teaching experience.',
    'headmaster' => 'The Principal of RM Model School is Mr. S. K. Roy (M.Sc, B.Ed).',
    'head' => 'The Head of the School is Mr. S. K. Roy.',

    // Address
    'address' => 'RM Model School is located at Buniadpur, Dakshin Dinajpur, West Bengal, 733121.',
    'location' => 'RM Model School is located at Buniadpur, Dakshin Dinajpur, West Bengal, 733121.',
    'where' => 'RM Model School is situated in Buniadpur, Dakshin Dinajpur district, West Bengal.',

    // Contact
    'contact' => 'You can contact RM Model School at 9064651620 or email: info@rmmodelschool.edu.',
    'phone' => 'School phone number: 9064651620. Office hours: 9:30 AM to 5:00 PM.',
    'mobile' => 'You can reach us at 9064651620.',
    'email' => 'Email: info@rmmodelschool.edu',

    // Timing
    'timing' => 'School timing: 10:00 AM to 4:00 PM (Monday to Friday). Saturdays are half-day (10:00 AM to 12:30 PM). Sunday closed.',
    'time' => 'School timing: 10:00 AM to 4:00 PM (Monday to Friday). Saturdays are half-day.',
    'shift' => 'We have a single shift from 10:00 AM to 4:00 PM.',

    // About / General
    'about' => 'RM Model School is a premier co-educational institution established in 2005, offering education from primary to higher secondary (classes 1–12) with CBSE curriculum.',
    'school' => 'RM Model School is a premier co-educational institution established in 2005, offering education from primary to higher secondary (classes 1–12) with CBSE curriculum.',
    'information' => 'RM Model School is a premier co-educational institution established in 2005, offering education from primary to higher secondary (classes 1–12) with CBSE curriculum.',

    // Fees
    'fees' => 'Annual tuition fees range from ₹25,000 to ₹45,000 depending on class. Additional charges for transport, lab, and activities. Contact the office for a detailed fee structure.',
    'fee' => 'Annual tuition fees range from ₹25,000 to ₹45,000 depending on class. Contact the office for details.',
    'cost' => 'Fees vary by class. Please call the office at 9064651620 for the latest fee structure.',
    'payment' => 'Fees can be paid online via bank transfer, or by cash/cheque at the school office.',

    // Admission
    'admission' => 'Admissions are open for classes 1 to 12. You can collect the admission form from the school office or download it from our website. Admission is based on a written test and interview.',
    'apply' => 'To apply, visit the school office with your child’s previous academic records, birth certificate, and passport-size photos. Forms are available from January to March.',
    'admit' => 'Admission process: fill the form, appear for an entrance test, and attend an interaction with the principal.',

    // Uniform
    'uniform' => 'School uniform: white shirt, navy blue trousers/skirt, and a blue tie. Sports uniform is a white t-shirt and navy blue shorts. Uniforms are available at the school store.',
    'dress' => 'The school dress code is formal (white and navy blue) on weekdays, and sports uniform on designated days.',

    // Transport
    'transport' => 'We provide bus transport for students within a 15 km radius. Bus routes cover major areas. Contact the transport in-charge for route details and fees.',
    'bus' => 'School bus service is available. Please call the office for route information and charges.',
    'vehicle' => 'We have a fleet of 5 buses covering various routes.',

    // Canteen / Meal
    'canteen' => 'The school has a hygienic canteen offering vegetarian snacks, lunch, and beverages. Students can pre-order meals monthly.',
    'meal' => 'Nutritious vegetarian meals are provided in the school canteen. Parents can opt for tiffin services as well.',

    // Sports
    'sports' => 'We have facilities for cricket, football, basketball, badminton, and athletics. A dedicated sports coach trains students for inter-school competitions.',
    'sport' => 'We offer cricket, football, basketball, badminton, and athletics. Annual sports day is held in December.',
    'play' => 'Students participate in various indoor and outdoor games. We have a playground and a multi-purpose hall.',

    // Exam schedule
    'exam' => 'Exams: Unit tests are conducted monthly. Half-yearly exams in September, and final exams in March. Practical exams are held for science subjects.',
    'test' => 'Regular unit tests, half-yearly, and annual examinations are held. Students are informed of the schedule well in advance.',
    'result' => 'Results are published on the school notice board and sent via SMS to parents. Digital copies are available on request.',

    // Holidays
    'holiday' => 'School holidays: Summer vacation (May–June), Puja holidays (October), and Christmas break (December 25). National holidays are observed.',
    'vacation' => 'Summer vacation: May to mid-June. Winter break: December 25 to January 2.',
    'leave' => 'Planned holidays are listed in the school calendar. For emergency leave, contact the class teacher.',

    // Fees payment
    'pay' => 'Fees can be paid online via bank transfer, or by cash/cheque at the school office.',
    'online' => 'We accept online payments via NEFT/RTGS. Account details are available on the school notice board.',

    // Staff details (more)
    'teacher count' => 'We have 35 teachers, including 8 postgraduate teachers, and 10 support staff.',

    // Class strength
    'class strength' => 'Average class size is 30 students, with a maximum of 35 per section.',
    'strength' => 'Each class has 25–35 students to ensure personalized attention.',

    // Extracurricular
    'activity' => 'We offer extracurricular activities like debate, music, dance, art, yoga, and robotics.',
    'cultural' => 'Cultural programs are held during annual day and festive celebrations. Students are encouraged to participate.'
];

$reply = "Sorry, I don't have information about that. Please call the school office at 9064651620 or email info@rmmodelschool.edu for more details.";
$lowerInput = strtolower($input);

// First, try to match a key exactly (with synonyms)
foreach ($answers as $key => $answer) {
    if (strpos($lowerInput, $key) !== false) {
        $reply = $answer;
        break;
    }
}

// If no match, try word-by-word matching (more flexible)
if ($reply === "Sorry, I don't have information about that. Please call the school office at 9064651620 or email info@rmmodelschool.edu for more details.") {
    $words = explode(' ', $lowerInput);
    foreach ($words as $word) {
        $word = trim($word);
        if (strlen($word) < 3) continue;
        foreach ($answers as $key => $answer) {
            if (strpos($key, $word) !== false || strpos($word, $key) !== false) {
                $reply = $answer;
                break 3;
            }
        }
    }
}

echo json_encode(['reply' => $reply]);
