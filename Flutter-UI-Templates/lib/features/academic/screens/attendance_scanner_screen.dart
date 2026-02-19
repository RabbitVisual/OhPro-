import 'dart:convert';
import 'package:audioplayers/audioplayers.dart';
import 'package:best_flutter_ui_templates/design_course/design_course_app_theme.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:mobile_scanner/mobile_scanner.dart';

class AttendanceScannerScreen extends StatefulWidget {
  const AttendanceScannerScreen({Key? key}) : super(key: key);

  @override
  _AttendanceScannerScreenState createState() => _AttendanceScannerScreenState();
}

class _AttendanceScannerScreenState extends State<AttendanceScannerScreen> {
  final MobileScannerController controller = MobileScannerController();
  final AudioPlayer audioPlayer = AudioPlayer();
  bool _isProcessing = false;

  @override
  void dispose() {
    controller.dispose();
    audioPlayer.dispose();
    super.dispose();
  }

  Future<void> _handleScan(BarcodeCapture capture) async {
    if (_isProcessing) return;
    final List<Barcode> barcodes = capture.barcodes;

    for (final barcode in barcodes) {
      if (barcode.rawValue == null) continue;

      setState(() {
        _isProcessing = true;
      });

      try {
        final String code = barcode.rawValue!;
        // Parse JSON
        // Example: {'id':1, 'uid':'...'}
        Map<String, dynamic> data;
        try {
          data = jsonDecode(code);
        } catch (e) {
          debugPrint('Not a valid JSON: $code');
          _showError('Código inválido: não é um JSON válido.');
          return;
        }

        if (data.containsKey('id') && data.containsKey('uid')) {
          await _processAttendance(data);
        } else {
          _showError('Código inválido: formato incorreto.');
        }

      } catch (e) {
        _showError('Erro ao processar código: $e');
      } finally {
         await Future.delayed(const Duration(seconds: 2));
         if (mounted) {
           setState(() {
             _isProcessing = false;
           });
         }
      }
      break;
    }
  }

  Future<void> _processAttendance(Map<String, dynamic> data) async {
    // Mock API call to /api/attendance/scan
    debugPrint('Calling /api/attendance/scan with $data');

    // Play success sound
    try {
        // Using SystemSound as a simple feedback
        await SystemSound.play(SystemSoundType.click);
        // Also try to play a beep if internet is available, but fail silently
        await audioPlayer.play(UrlSource('https://actions.google.com/sounds/v1/cartoon/clown_horn.ogg'));
    } catch(e) {
        debugPrint("Error playing sound: $e");
    }

    if (mounted) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Presença confirmada para Aluno ID: ${data['id']}'),
          backgroundColor: Colors.green,
          duration: const Duration(seconds: 1),
        ),
      );
    }
  }

  void _showError(String message) {
    if (mounted) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(message),
          backgroundColor: Colors.red,
        ),
      );
    }
    // _isProcessing is reset in finally block
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Escanear Chamada'),
        backgroundColor: DesignCourseAppTheme.nearlyWhite,
        iconTheme: const IconThemeData(color: DesignCourseAppTheme.darkerText),
        titleTextStyle: const TextStyle(
            color: DesignCourseAppTheme.darkerText,
            fontSize: 20,
            fontWeight: FontWeight.bold),
        actions: [
          IconButton(
            icon: ValueListenableBuilder(
              valueListenable: controller.torchState,
              builder: (context, state, child) {
                switch (state) {
                  case TorchState.off:
                    return const Icon(Icons.flash_off, color: Colors.grey);
                  case TorchState.on:
                    return const Icon(Icons.flash_on, color: Colors.yellow);
                }
              },
            ),
            onPressed: () => controller.toggleTorch(),
          ),
          IconButton(
            icon: ValueListenableBuilder(
              valueListenable: controller.cameraFacingState,
              builder: (context, state, child) {
                switch (state) {
                  case CameraFacing.front:
                    return const Icon(Icons.camera_front);
                  case CameraFacing.back:
                    return const Icon(Icons.camera_rear);
                }
              },
            ),
            onPressed: () => controller.switchCamera(),
          ),
        ],
      ),
      body: Stack(
        children: [
          MobileScanner(
            controller: controller,
            onDetect: _handleScan,
          ),
          Center(
            child: Container(
              width: 250,
              height: 250,
              decoration: BoxDecoration(
                border: Border.all(color: Colors.white, width: 2),
                borderRadius: BorderRadius.circular(12),
              ),
            ),
          ),
          if (_isProcessing)
            Container(
              color: Colors.black54,
              child: const Center(
                child: CircularProgressIndicator(),
              ),
            ),
        ],
      ),
    );
  }
}
