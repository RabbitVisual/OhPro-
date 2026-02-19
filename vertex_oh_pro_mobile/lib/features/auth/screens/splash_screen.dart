import 'package:flutter/material.dart';
import 'package:get/get.dart';
import '../controllers/auth_controller.dart';
import '../../../core/theme/app_theme.dart';

class SplashScreen extends StatelessWidget {
  const SplashScreen({super.key});

  @override
  Widget build(BuildContext context) {
    // Initialize controller to check auth status
    Get.put(AuthController());

    return Scaffold(
      backgroundColor: AppTheme.notWhite,
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(Icons.diamond, size: 80, color: AppTheme.primaryColor),
            SizedBox(height: 20),
            Text(
              'VertexOhPro',
              style: AppTheme.headline,
            ),
            SizedBox(height: 20),
            CircularProgressIndicator(color: AppTheme.primaryColor),
          ],
        ),
      ),
    );
  }
}
