class LessonPlan {
  LessonPlan({
    this.title = '',
    this.subject = '',
    this.date = '',
    this.imagePath = '',
    this.pdfUrl = '',
    this.rating = 4.5,
  });

  String title;
  String subject;
  String date;
  String imagePath;
  String pdfUrl;
  double rating;

  static List<LessonPlan> lessonPlans = <LessonPlan>[
    LessonPlan(
      title: 'Mathematics: Algebra Basics',
      subject: 'Math',
      date: '2023-10-25',
      imagePath: 'assets/hotel/hotel_1.png', // Placeholder
      pdfUrl: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
      rating: 4.8,
    ),
    LessonPlan(
      title: 'History: World War II',
      subject: 'History',
      date: '2023-10-26',
      imagePath: 'assets/hotel/hotel_2.png',
      pdfUrl: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
      rating: 4.5,
    ),
    LessonPlan(
      title: 'Physics: Newton\'s Laws',
      subject: 'Physics',
      date: '2023-10-27',
      imagePath: 'assets/hotel/hotel_3.png',
      pdfUrl: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
      rating: 4.9,
    ),
    LessonPlan(
      title: 'Chemistry: Periodic Table',
      subject: 'Chemistry',
      date: '2023-10-28',
      imagePath: 'assets/hotel/hotel_4.png',
      pdfUrl: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
      rating: 4.6,
    ),
      LessonPlan(
      title: 'Literature: Shakespeare',
      subject: 'English',
      date: '2023-10-29',
      imagePath: 'assets/hotel/hotel_5.png',
      pdfUrl: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
      rating: 4.7,
    ),
  ];
}
