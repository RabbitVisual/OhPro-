import 'package:best_flutter_ui_templates/design_course/design_course_app_theme.dart';
import 'package:best_flutter_ui_templates/features/academic/models/class_model.dart';
import 'package:best_flutter_ui_templates/features/academic/screens/attendance_scanner_screen.dart';
import 'package:flutter/material.dart';

class ClassDetailScreen extends StatefulWidget {
  const ClassDetailScreen({Key? key, required this.classModel}) : super(key: key);

  final ClassModel classModel;

  @override
  _ClassDetailScreenState createState() => _ClassDetailScreenState();
}

class _ClassDetailScreenState extends State<ClassDetailScreen> with SingleTickerProviderStateMixin {
  late TabController _tabController;

  @override
  void initState() {
    super.initState();
    _tabController = TabController(length: 2, vsync: this);
  }

  @override
  void dispose() {
    _tabController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(widget.classModel.name),
        backgroundColor: DesignCourseAppTheme.nearlyWhite,
        iconTheme: IconThemeData(color: DesignCourseAppTheme.darkerText),
        titleTextStyle: TextStyle(
            color: DesignCourseAppTheme.darkerText,
            fontSize: 20,
            fontWeight: FontWeight.bold),
        bottom: TabBar(
          controller: _tabController,
          labelColor: DesignCourseAppTheme.nearlyBlue,
          unselectedLabelColor: DesignCourseAppTheme.grey,
          tabs: const [
            Tab(text: 'Alunos'),
            Tab(text: 'Chamada'),
          ],
        ),
      ),
      body: TabBarView(
        controller: _tabController,
        children: [
          _buildStudentsTab(),
          _buildAttendanceTab(),
        ],
      ),
    );
  }

  Widget _buildStudentsTab() {
    return ListView.builder(
      itemCount: widget.classModel.studentCount,
      itemBuilder: (context, index) {
        return ListTile(
          leading: CircleAvatar(
            backgroundColor: DesignCourseAppTheme.nearlyBlue.withOpacity(0.2),
            child: Text('${index + 1}'),
          ),
          title: Text('Aluno ${index + 1}'),
          subtitle: Text('Matrícula: 2023${index.toString().padLeft(4, '0')}'),
        );
      },
    );
  }

  Widget _buildAttendanceTab() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(Icons.qr_code_scanner, size: 100, color: DesignCourseAppTheme.nearlyBlue),
          const SizedBox(height: 20),
          ElevatedButton(
            style: ElevatedButton.styleFrom(
              backgroundColor: DesignCourseAppTheme.nearlyBlue,
              padding: const EdgeInsets.symmetric(horizontal: 32, vertical: 16),
            ),
            onPressed: () {
              Navigator.push(
                context,
                MaterialPageRoute(builder: (context) => const AttendanceScannerScreen()),
              );
            },
            child: const Text(
              'Iniciar Chamada',
              style: TextStyle(fontSize: 18, color: Colors.white),
            ),
          ),
        ],
      ),
    );
  }
}
