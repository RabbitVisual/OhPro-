import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:dio/dio.dart';
import '../../../core/network/api_client.dart';
import '../screens/login_screen.dart';

class AuthController extends GetxController {
  final isLoading = false.obs;

  @override
  void onInit() {
    super.onInit();
    checkLoginStatus();
  }

  Future<void> checkLoginStatus() async {
    final prefs = await SharedPreferences.getInstance();
    finaltoken = prefs.getString('auth_token');
    if (finaltoken != null) {
      // Validate token or just go to home
      // For now, assuming valid
      Get.offAllNamed('/home');
    } else {
      Get.offAll(() => const LoginScreen());
    }
  }

  Future<void> login(String email, String password) async {
    try {
      isLoading.value = true;
      final response = await ApiClient().dio.post('/login', data: {
        'email': email,
        'password': password,
      });

      if (response.statusCode == 200) {
        final token = response.data['token'];
        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('auth_token', token);
        Get.offAllNamed('/home');
      }
    } on DioException catch (e) {
      Get.snackbar('Error', e.response?.data['message'] ?? 'Login failed');
    } finally {
      isLoading.value = false;
    }
  }

  Future<void> logout() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
    Get.offAll(() => const LoginScreen());
  }
}
