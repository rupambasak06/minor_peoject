<?php
// index.php - Public Landing Page with Chatbot
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RM Model School – Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .hero-gradient { background: linear-gradient(135deg, #0f2b45 0%, #1a3b5d 40%, #2a5f7a 100%); }
        .hero-wave { position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; line-height: 0; }
        .hero-wave svg { display: block; width: 100%; height: 70px; }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); }
        .chat-avatar { background: #1a3b5d; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px; }
        #chat-messages::-webkit-scrollbar { width: 4px; }
        #chat-messages::-webkit-scrollbar-track { background: #f1f1f1; }
        #chat-messages::-webkit-scrollbar-thumb { background: #1a3b5d; border-radius: 8px; }
        #chat-icon { animation: pulse 2s infinite; }
        @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(26,59,93,0.7); } 70% { box-shadow: 0 0 0 15px rgba(26,59,93,0); } 100% { box-shadow: 0 0 0 0 rgba(26,59,93,0); } }
        .btn-primary { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); }
        .btn-primary:hover { transform: scale(1.05); box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.4); }
        .card-hover { transition: all 0.3s; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); }
        /* Navbar toggle styles */
        .nav-menu { display: flex; align-items: center; gap: 1.5rem; }
        .nav-menu.active { display: flex; flex-direction: column; position: absolute; top: 100%; left: 0; right: 0; background: #0f2b45; padding: 1rem 2rem; gap: 1rem; border-bottom: 2px solid rgba(255,255,255,0.1); }
        @media (max-width: 768px) { .nav-menu { display: none; } .nav-menu.active { display: flex; } }
        .menu-toggle { display: none; cursor: pointer; font-size: 1.5rem; }
        @media (max-width: 768px) { .menu-toggle { display: block; } }
    </style>
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="bg-[#0f2b45] text-white shadow-lg sticky top-0 z-50 border-b border-white/10 relative">
        <div class="container mx-auto px-4 py-3 flex flex-wrap items-center justify-between">
            <a href="#" class="flex items-center gap-3">
                <div class="bg-yellow-400 w-10 h-10 rounded-xl flex items-center justify-center text-2xl shadow-lg">🏫</div>
                <div>
                    <span class="text-xl font-extrabold text-white">RM <span class="text-yellow-400">Model</span></span>
                    <span class="hidden sm:inline text-xs text-gray-300 block -mt-1">School</span>
                </div>
            </a>
            <!-- Desktop Navigation -->
            <div class="nav-menu" id="navMenu">
                <a href="#about" class="hover:text-yellow-400 transition font-medium">About</a>
                <a href="#contact" class="hover:text-yellow-400 transition font-medium">Contact</a>
                <a href="dashboard.php" class="bg-yellow-400 text-[#0f2b45] px-4 py-1.5 rounded-full font-bold text-sm hover:bg-yellow-300 transition shadow-md flex items-center gap-1">
                    <i class="fas fa-chart-line"></i> Admin
                </a>
            </div>
            <!-- Mobile toggle -->
            <div class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <section class="relative hero-gradient text-white overflow-hidden">
        <div class="container mx-auto px-4 py-16 md:py-24 text-center relative z-10">
            <div class="flex flex-col items-center mb-6">
                <div class="bg-yellow-400 w-24 h-24 md:w-32 md:h-32 rounded-3xl flex items-center justify-center text-5xl md:text-6xl shadow-2xl transform rotate-3 hover:rotate-0 transition-all duration-500">🏫</div>
                <h1 class="text-4xl md:text-6xl font-extrabold mt-4 tracking-tight">RM <span class="text-yellow-400">Model</span> School</h1>
                <p class="text-yellow-300/80 text-sm md:text-base font-medium mt-1">Est. 2005 | Buniadpur, Dakshin Dinajpur</p>
            </div>
            <p class="text-lg md:text-xl max-w-2xl mx-auto opacity-90 leading-relaxed">Empowering young minds through excellence in education, character development, and community values.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="#about" class="btn-primary text-[#0f2b45] px-8 py-3 rounded-full font-bold transition shadow-lg flex items-center gap-2"><i class="fas fa-info-circle"></i> Learn More</a>
                <a href="#contact" class="bg-white/10 backdrop-blur-sm text-white px-8 py-3 rounded-full font-medium hover:bg-white/20 transition border border-white/30 flex items-center gap-2"><i class="fas fa-phone-alt"></i> Contact Us</a>
            </div>
        </div>
        <div class="hero-wave"><svg viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0 C300,100 600,20 1200,60 L1200,120 L0,120 Z" fill="#f8fafc" opacity="1"/></svg></div>
    </section>

    <!-- ===== STATS ===== -->
    <section class="container mx-auto px-4 -mt-10 relative z-20">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div class="stat-card bg-white p-6 rounded-2xl shadow-lg text-center border-t-4 border-[#1a3b5d]"><i class="fas fa-users text-3xl text-[#1a3b5d] mb-2"></i><h3 class="text-3xl md:text-4xl font-bold text-[#1a3b5d]">520+</h3><p class="text-gray-600 font-semibold text-sm md:text-base">Students</p></div>
            <div class="stat-card bg-white p-6 rounded-2xl shadow-lg text-center border-t-4 border-[#1a3b5d]"><i class="fas fa-chalkboard-teacher text-3xl text-[#1a3b5d] mb-2"></i><h3 class="text-3xl md:text-4xl font-bold text-[#1a3b5d]">35</h3><p class="text-gray-600 font-semibold text-sm md:text-base">Teachers</p></div>
            <div class="stat-card bg-white p-6 rounded-2xl shadow-lg text-center border-t-4 border-[#1a3b5d]"><i class="fas fa-door-open text-3xl text-[#1a3b5d] mb-2"></i><h3 class="text-3xl md:text-4xl font-bold text-[#1a3b5d]">20</h3><p class="text-gray-600 font-semibold text-sm md:text-base">Classrooms</p></div>
            <div class="stat-card bg-white p-6 rounded-2xl shadow-lg text-center border-t-4 border-[#1a3b5d]"><i class="fas fa-calendar-alt text-3xl text-[#1a3b5d] mb-2"></i><h3 class="text-3xl md:text-4xl font-bold text-[#1a3b5d]">2005</h3><p class="text-gray-600 font-semibold text-sm md:text-base">Established</p></div>
        </div>
    </section>

    <!-- ===== ABOUT ===== -->
    <section id="about" class="container mx-auto px-4 py-16 md:py-20 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-[#0f2b45] mb-6"><i class="fas fa-school text-yellow-500 mr-2"></i> About Our School</h2>
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-xl card-hover">
            <p class="text-gray-700 text-base md:text-lg leading-relaxed">RM Model School is a premier educational institution located at <strong>Buniadpur, Dakshin Dinajpur, West Bengal</strong>. We provide quality education from primary to higher secondary level with a strong focus on academic excellence, character development, and co‑curricular activities.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-6 text-sm md:text-base">
                <span class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> Experienced Faculty</span>
                <span class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> Smart Classrooms</span>
                <span class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> Sports & Arts</span>
                <span class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> Safe Environment</span>
            </div>
        </div>
    </section>

    <!-- ===== CONTACT ===== -->
    <section id="contact" class="bg-gray-100 py-16 px-4">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0f2b45] mb-6"><i class="fas fa-address-card text-yellow-500 mr-2"></i> Get in Touch</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-white p-6 rounded-2xl shadow-md card-hover"><i class="fas fa-map-marker-alt text-3xl text-[#1a3b5d] mb-3"></i><h4 class="font-bold">Address</h4><p class="text-gray-600 text-sm">Buniadpur, Dakshin Dinajpur, WB – 733121</p></div>
                <div class="bg-white p-6 rounded-2xl shadow-md card-hover"><i class="fas fa-phone-alt text-3xl text-[#1a3b5d] mb-3"></i><h4 class="font-bold">Phone</h4><p class="text-gray-600 text-sm"><a href="tel:9064651620" class="text-[#1a3b5d] hover:underline">9064651620</a></p></div>
                <div class="bg-white p-6 rounded-2xl shadow-md card-hover"><i class="fas fa-envelope text-3xl text-[#1a3b5d] mb-3"></i><h4 class="font-bold">Email</h4><p class="text-gray-600 text-sm"><a href="mailto:info@rmmodelschool.edu" class="text-[#1a3b5d] hover:underline">info@rmmodelschool.edu</a></p></div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-[#0f2b45] text-gray-400 py-8 px-4 border-t border-white/10">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm">&copy; 2026 RM Model School. All rights reserved.</p>
            <p class="text-sm">Developed for <span class="text-yellow-400">BCA Minor Project</span></p>
            <p class="text-sm">Created by <span class="text-yellow-400">Rupam Basak</span></p>
            <div class="flex gap-4 text-lg">
                <a href="#" class="hover:text-yellow-400 transition"><i class="fab fa-facebook"></i></a>
                <a href="#" class="hover:text-yellow-400 transition"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-yellow-400 transition"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </footer>

    <!-- ===== CHATBOT ===== -->
    <button id="chat-icon" class="fixed bottom-6 right-6 bg-[#1a3b5d] text-white w-14 h-14 md:w-16 md:h-16 rounded-full shadow-2xl flex items-center justify-center text-2xl md:text-3xl hover:bg-yellow-400 hover:text-[#1a3b5d] transition-all duration-300 z-50 border-0 cursor-pointer"><i class="fas fa-comment-dots"></i></button>
    <div id="chat-box" class="fixed bottom-24 right-4 md:right-6 w-[calc(100%-2rem)] max-w-sm bg-white rounded-2xl shadow-2xl hidden flex-col z-50 border border-gray-200 overflow-hidden">
        <div class="bg-[#1a3b5d] text-white px-4 py-3 flex justify-between items-center">
            <div class="flex items-center gap-2"><div class="chat-avatar"><i class="fas fa-robot"></i></div><span class="font-bold">RM School Assistant</span></div>
            <span id="chat-close" class="text-xl cursor-pointer hover:text-yellow-400 transition">✕</span>
        </div>
        <div id="chat-messages" class="h-72 overflow-y-auto p-4 bg-gray-50 space-y-2">
            <div class="flex items-start gap-2"><div class="chat-avatar flex-shrink-0 w-8 h-8 text-sm"><i class="fas fa-robot"></i></div><div class="bg-gray-200 text-gray-800 rounded-2xl rounded-bl-none px-4 py-2 max-w-[85%] text-sm">Hello! 👋 I'm your school assistant. Ask me about teachers, students, classrooms, address, or contact info!</div></div>
        </div>
        <div class="flex items-center gap-2 p-3 border-t border-gray-200 bg-white">
            <input type="text" id="chat-input" placeholder="Type your question..." class="flex-1 px-4 py-2.5 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#1a3b5d]">
            <button id="chat-send" class="bg-[#1a3b5d] text-white w-11 h-11 rounded-full flex items-center justify-center text-lg hover:bg-yellow-400 hover:text-[#1a3b5d] transition"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatIcon = document.getElementById('chat-icon');
            const chatBox = document.getElementById('chat-box');
            const chatClose = document.getElementById('chat-close');
            const chatInput = document.getElementById('chat-input');
            const chatSend = document.getElementById('chat-send');
            const chatMessages = document.getElementById('chat-messages');

            chatIcon.addEventListener('click', function() {
                chatBox.classList.toggle('hidden');
                if (!chatBox.classList.contains('hidden')) chatInput.focus();
            });
            chatClose.addEventListener('click', function() {
                chatBox.classList.add('hidden');
            });

            const answers = {
    // ===== TEACHERS & STAFF =====
    'teachers': 'RM Model School has 35 dedicated and highly qualified teachers, including subject experts and co-curricular instructors.',
    'teacher': 'RM Model School has 35 dedicated and highly qualified teachers.',
    'faculty': 'RM Model School has 35 dedicated teachers and 10 support staff members.',
    'staff': 'RM Model School has 35 teachers and 10 administrative and support staff.',
    'sir': 'All our teachers are highly qualified and experienced professionals.',
    'madam': 'All our teachers are highly qualified and experienced professionals.',

    // ===== STUDENTS =====
    'students': 'RM Model School has 520 enrolled students across classes 1 to 12.',
    'student': 'RM Model School has 520 enrolled students.',
    'pupil': 'RM Model School has 520 enrolled students.',
    'children': 'RM Model School has 520 children from diverse backgrounds.',
    'enrollment': 'Total enrollment is 520 students across all classes.',
    'admission': 'Admissions are open for classes 1 to 12. Forms are available at the school office. Admission is based on a written test and interview.',
    'admit': 'Admission process: fill the form, appear for an entrance test, and attend an interaction with the principal.',

    // ===== SUBJECTS =====
    'subjects': 'We offer Mathematics, English, Science, Computer Science, Bengali, and Social Science at various levels.',
    'subject': 'We offer Mathematics, English, Science, Computer Science, Bengali, and Social Science.',
    'math': 'Mathematics is taught from class 1 to 12 with experienced faculty.',
    'mathematics': 'Mathematics is taught from class 1 to 12 with experienced faculty.',
    'english': 'English is a core subject with focus on grammar, literature, and communication skills.',
    'science': 'Science includes Physics, Chemistry, and Biology with practical lab sessions.',
    'physics': 'Physics is taught with practical experiments in our science lab.',
    'chemistry': 'Chemistry is taught with practical experiments in our science lab.',
    'biology': 'Biology is taught with practical experiments in our science lab.',
    'computer': 'Computer Science is taught from class 1 with practical lab sessions.',
    'computer science': 'Computer Science is taught with hands-on programming and lab sessions.',
    'bengali': 'Bengali is offered as a language subject from class 1 to 12.',
    'social': 'Social Science includes History, Geography, and Civics.',
    'history': 'History is taught as part of Social Science curriculum.',
    'geography': 'Geography is taught as part of Social Science curriculum.',

    // ===== CLASSROOMS & INFRASTRUCTURE =====
    'rooms': 'RM Model School has 20 smart classrooms, 1 computer lab, 1 science lab, a library, and a large auditorium.',
    'room': 'RM Model School has 20 smart classrooms, 1 computer lab, 1 science lab, a library, and a large auditorium.',
    'classroom': 'RM Model School has 20 smart classrooms equipped with digital boards and projectors.',
    'lab': 'We have a fully equipped computer lab with 30 PCs and a separate science lab for physics, chemistry, and biology experiments.',
    'library': 'Our library has over 5,000 books, magazines, and digital resources. Students can borrow books every week.',
    'auditorium': 'The school has a 300-seat auditorium for events, assemblies, and cultural programs.',
    'playground': 'We have a large playground for cricket, football, and athletics.',
    'ground': 'We have a large playground for cricket, football, and athletics.',
    'campus': 'Our campus is spread over 5 acres with modern facilities and a green environment.',
    'building': 'The school building has 3 floors with 20 classrooms, labs, and administrative offices.',

    // ===== PRINCIPAL & MANAGEMENT =====
    'principal': 'The Principal of RM Model School is Mr. S. K. Roy (M.Sc, B.Ed) with 20 years of teaching experience.',
    'headmaster': 'The Principal of RM Model School is Mr. Rupam Basak (M.Sc, B.Ed).',
    'head': 'The Head of the School is Mr. A. R. Roy.',
    'management': 'The school is managed by the RM Model School Trust with a dedicated governing body.',

    // ===== ADDRESS & LOCATION =====
    'address': 'RM Model School is located at Buniadpur, Dakshin Dinajpur, West Bengal, 733121.',
    'location': 'RM Model School is located at Buniadpur, Dakshin Dinajpur, West Bengal, 733121.',
    'where': 'RM Model School is situated in Buniadpur, Dakshin Dinajpur district, West Bengal.',
    'area': 'Our school is located in Buniadpur, Dakshin Dinajpur, West Bengal.',

    // ===== CONTACT =====
    'contact': 'You can contact RM Model School at 9064651620 or email: info@rmmodelschool.edu.',
    'phone': 'School phone number: 9064651620. Office hours: 9:30 AM to 5:00 PM.',
    'mobile': 'You can reach us at 9064651620.',
    'email': 'Email: info@rmmodelschool.edu',
    'call': 'You can call us at 9064651620 during office hours.',

    // ===== TIMING =====
    'timing': 'School timing: 10:00 AM to 4:00 PM (Monday to Friday). Saturdays are half-day (10:00 AM to 12:30 PM). Sunday closed.',
    'time': 'School timing: 10:00 AM to 4:00 PM (Monday to Friday). Saturdays are half-day.',
    'shift': 'We have a single shift from 10:00 AM to 4:00 PM.',
    'office hours': 'Office hours are 9:30 AM to 5:00 PM on all working days.',
    'schedule': 'The school day starts at 10:00 AM and ends at 4:00 PM with a lunch break.',

    // ===== FEES =====
    'fees': 'Annual tuition fees range from ₹25,000 to ₹45,000 depending on class. Additional charges for transport, lab, and activities. Contact the office for a detailed fee structure.',
    'fee': 'Annual tuition fees range from ₹25,000 to ₹45,000 depending on class. Contact the office for details.',
    'cost': 'Fees vary by class. Please call the office at 9064651620 for the latest fee structure.',
    'payment': 'Fees can be paid online via bank transfer, or by cash/cheque at the school office.',
    'pay': 'Fees can be paid online via bank transfer, or by cash/cheque at the school office.',
    'online': 'We accept online payments via NEFT/RTGS. Account details are available on the school notice board.',

    // ===== UNIFORM =====
    'uniform': 'School uniform: white shirt, navy blue trousers/skirt, and a blue tie. Sports uniform is a white t-shirt and navy blue shorts. Uniforms are available at the school store.',
    'dress': 'The school dress code is formal (white and navy blue) on weekdays, and sports uniform on designated days.',
    'wear': 'Students must wear the full school uniform on all working days.',

    // ===== TRANSPORT =====
    'transport': 'We provide bus transport for students within a 15 km radius. Bus routes cover major areas. Contact the transport in-charge for route details and fees.',
    'bus': 'School bus service is available. Please call the office for route information and charges.',
    'vehicle': 'We have a fleet of 5 buses covering various routes.',

    // ===== CANTEEN / MEAL =====
    'canteen': 'The school has a hygienic canteen offering vegetarian snacks, lunch, and beverages. Students can pre-order meals monthly.',
    'meal': 'Nutritious vegetarian meals are provided in the school canteen. Parents can opt for tiffin services as well.',
    'food': 'The canteen serves hygienic vegetarian food. No non-vegetarian items are allowed on campus.',
    'lunch': 'Lunch is available in the canteen. Students can bring their own lunch or order from the canteen.',

    // ===== SPORTS =====
    'sports': 'We have facilities for cricket, football, basketball, badminton, and athletics. A dedicated sports coach trains students for inter-school competitions.',
    'sport': 'We offer cricket, football, basketball, badminton, and athletics. Annual sports day is held in December.',
    'play': 'Students participate in various indoor and outdoor games. We have a playground and a multi-purpose hall.',
    'cricket': 'We have a cricket team that participates in inter-school tournaments.',
    'football': 'We have a football team that participates in inter-school tournaments.',
    'basketball': 'We have a basketball court and a team that participates in competitions.',
    'badminton': 'We have badminton courts available for students.',
    'athletics': 'We have athletics facilities for track and field events.',

    // ===== EXAM =====
    'exam': 'Exams: Unit tests are conducted monthly. Half-yearly exams in September, and final exams in March. Practical exams are held for science subjects.',
    'test': 'Regular unit tests, half-yearly, and annual examinations are held. Students are informed of the schedule well in advance.',
    'result': 'Results are published on the school notice board and sent via SMS to parents. Digital copies are available on request.',
    'marks': 'Marks are updated in the system regularly. Students can view their marks through the school portal.',
    'grade': 'Grades are awarded based on performance in exams and continuous assessment.',

    // ===== HOLIDAYS =====
    'holiday': 'School holidays: Summer vacation (May–June), Puja holidays (October), and Christmas break (December 25). National holidays are observed.',
    'vacation': 'Summer vacation: May to mid-June. Winter break: December 25 to January 2.',
    'leave': 'Planned holidays are listed in the school calendar. For emergency leave, contact the class teacher.',
    'summer': 'Summer vacation is from May to mid-June.',
    'puja': 'Puja holidays are in October for about 2 weeks.',
    'christmas': 'Christmas break is from December 25 to January 2.',

    // ===== ACTIVITIES =====
    'activity': 'We offer extracurricular activities like debate, music, dance, art, yoga, and robotics.',
    'cultural': 'Cultural programs are held during annual day and festive celebrations. Students are encouraged to participate.',
    'debate': 'We have a debate club that participates in inter-school competitions.',
    'music': 'Music classes are available for interested students. We have a school band.',
    'dance': 'Dance classes are available for interested students.',
    'art': 'Art classes are available for interested students. We participate in art competitions.',
    'yoga': 'Yoga classes are conducted weekly for all students.',
    'robotics': 'We have a robotics club that participates in competitions.',
    'drama': 'Drama and theatre activities are organized during cultural events.',

    // ===== EXTRA INFORMATION =====
    'about': 'RM Model School is a premier co-educational institution established in 2005, offering education from primary to higher secondary (classes 1–12) with CBSE curriculum.',
    'school': 'RM Model School is a premier co-educational institution established in 2005.',
    'information': 'RM Model School is a premier co-educational institution established in 2005, offering education from primary to higher secondary (classes 1–12) with CBSE curriculum.',
    'history': 'RM Model School was established in 2005 and has been serving the community for over 20 years.',
    'founder': 'The school was founded by the RM Model School Trust in 2005.',
    'vision': 'Our vision is to provide quality education and nurture future leaders.',
    'mission': 'Our mission is to empower young minds through excellence in education, character development, and community values.',
    'affiliation': 'We follow the CBSE curriculum from classes 1 to 12.',
    'cbse': 'We are affiliated with the CBSE board.',
    'board': 'We follow the CBSE curriculum.',
    'class': 'We offer education from classes 1 to 12.',
    'classes': 'We offer education from primary to higher secondary (classes 1 to 12).',
    'section': 'We have multiple sections for each class to maintain an average of 30 students per section.',
    'medium': 'The medium of instruction is English.',
    'english medium': 'We are an English medium school.',
    'coeducational': 'We are a co-educational school with students from all backgrounds.',
    'established': 'RM Model School was established in 2005.',
    'since': 'RM Model School has been serving the community since 2005.',
    'strength': 'Average class size is 30 students, with a maximum of 35 per section.',
    'ratio': 'The student-teacher ratio is approximately 15:1.',
    'facilities': 'We have smart classrooms, labs, library, playground, auditorium, and canteen facilities.',
    'infrastructure': 'Our infrastructure includes 20 classrooms, labs, library, playground, and auditorium.',
    'safety': 'The school has a safe and secure environment with CCTV surveillance.',
    'security': 'CCTV cameras and security guards ensure the safety of all students.',
    'discipline': 'We maintain high standards of discipline and punctuality.',
    'rules': 'Students must follow the school rules and wear the prescribed uniform.',
    'regulation': 'School regulations are available in the student handbook.',
    'parent': 'Parents are encouraged to attend parent-teacher meetings and stay involved in their child\'s education.',
    'parents': 'Parent-teacher meetings are held every quarter.',
    'ptm': 'Parent-Teacher Meetings are held every quarter to discuss student progress.',
    'teacher parent': 'Parent-Teacher Meetings are held every quarter.',
    'report': 'Student progress reports are shared with parents during PTM.',
    'performance': 'Student performance is tracked throughout the year.',
    'progress': 'Student progress is monitored through regular tests and assignments.',
    'learning': 'We focus on holistic learning with a blend of academics and co-curricular activities.',
    'education': 'We provide quality education with a focus on all-round development.',
    'quality': 'We are committed to providing quality education to all students.',
    'excellence': 'We strive for academic excellence and character development.',
    'academic': 'Our academic program is comprehensive and well-structured.',
    'curriculum': 'We follow the CBSE curriculum with a focus on conceptual understanding.',
    'syllabus': 'The syllabus is designed as per CBSE guidelines.',
    'teaching': 'Our teaching methods are interactive and student-centered.',
    'teacher student': 'Our teachers are dedicated and supportive.',
    'staff teacher': 'Our teachers and staff are always available to help students.'
};

            function getReply(input) {
                const lower = input.toLowerCase().trim();
                for (let key in answers) {
                    if (lower.includes(key)) {
                        return answers[key];
                    }
                }
                const words = lower.split(' ');
                for (let word of words) {
                    if (word.length < 3) continue;
                    for (let key in answers) {
                        if (key.includes(word) || word.includes(key)) {
                            return answers[key];
                        }
                    }
                }
                return "Sorry, I don't have information about that. Please call 9064651620 or email info@rmmodelschool.edu.";
            }

            function sendMessage() {
                const msg = chatInput.value.trim();
                if (msg === '') return;

                const userDiv = document.createElement('div');
                userDiv.className = 'flex items-start gap-2 justify-end';
                userDiv.innerHTML = `<div class="bg-[#1a3b5d] text-white rounded-2xl rounded-br-none px-4 py-2 max-w-[85%] text-sm">${msg}</div><div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-sm text-gray-600"><i class="fas fa-user"></i></div>`;
                chatMessages.appendChild(userDiv);
                chatInput.value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;

                const typingDiv = document.createElement('div');
                typingDiv.className = 'flex items-start gap-2';
                typingDiv.id = 'typing';
                typingDiv.innerHTML = `<div class="chat-avatar w-8 h-8 text-sm"><i class="fas fa-robot"></i></div><div class="bg-gray-200 text-gray-500 rounded-2xl rounded-bl-none px-4 py-2 text-sm italic">Typing...</div>`;
                chatMessages.appendChild(typingDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;

                setTimeout(() => {
                    const reply = getReply(msg);
                    const typing = document.getElementById('typing');
                    if (typing) typing.remove();

                    const botDiv = document.createElement('div');
                    botDiv.className = 'flex items-start gap-2';
                    botDiv.innerHTML = `<div class="chat-avatar w-8 h-8 text-sm"><i class="fas fa-robot"></i></div><div class="bg-gray-200 text-gray-800 rounded-2xl rounded-bl-none px-4 py-2 max-w-[85%] text-sm">${reply}</div>`;
                    chatMessages.appendChild(botDiv);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, 400);
            }

            chatSend.addEventListener('click', sendMessage);
            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') sendMessage();
            });

            // Navbar toggle
            document.getElementById('menuToggle').addEventListener('click', function() {
                document.getElementById('navMenu').classList.toggle('active');
            });
        });
    </script>
</body>
</html>