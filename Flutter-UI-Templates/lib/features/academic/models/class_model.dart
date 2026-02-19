class ClassModel {
  ClassModel({
    required this.id,
    required this.name,
    required this.subject,
    this.studentCount = 0,
    this.schedule = '',
    this.imagePath = '',
  });

  final String id;
  final String name;
  final String subject;
  final int studentCount;
  final String schedule;
  final String imagePath;

  static List<ClassModel> classList = <ClassModel>[
    ClassModel(
      id: '1',
      name: 'Turma A',
      subject: 'Matemática',
      studentCount: 30,
      schedule: 'Seg/Qua 08:00',
      imagePath: 'assets/design_course/interFace1.png',
    ),
    ClassModel(
      id: '2',
      name: 'Turma B',
      subject: 'Física',
      studentCount: 25,
      schedule: 'Ter/Qui 10:00',
      imagePath: 'assets/design_course/interFace2.png',
    ),
    ClassModel(
      id: '3',
      name: 'Turma C',
      subject: 'Química',
      studentCount: 28,
      schedule: 'Seg/Qua 14:00',
      imagePath: 'assets/design_course/interFace3.png',
    ),
  ];
}
