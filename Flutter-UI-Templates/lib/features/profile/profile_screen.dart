import 'package:best_flutter_ui_templates/app_theme.dart';
import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'edit_profile_screen.dart';
import 'notifications_screen.dart';

class ProfileScreen extends StatefulWidget {
  @override
  _ProfileScreenState createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  @override
  Widget build(BuildContext context) {
    var brightness = MediaQuery.of(context).platformBrightness;
    bool isLightMode = brightness == Brightness.light;
    return Container(
      color: isLightMode ? AppTheme.nearlyWhite : AppTheme.nearlyBlack,
      child: SafeArea(
        top: false,
        child: Scaffold(
          backgroundColor:
              isLightMode ? AppTheme.nearlyWhite : AppTheme.nearlyBlack,
          appBar: AppBar(
             backgroundColor: Colors.transparent,
             elevation: 0,
             leading: IconButton(
               icon: Icon(Icons.arrow_back, color: isLightMode ? AppTheme.darkText : AppTheme.white),
               onPressed: () => Navigator.pop(context),
             ),
             actions: [
               IconButton(
                 icon: Icon(Icons.notifications, color: isLightMode ? AppTheme.darkText : AppTheme.white),
                 onPressed: () {
                   Navigator.push(context, MaterialPageRoute(builder: (context) => NotificationsScreen()));
                 },
               )
             ],
          ),
          body: SingleChildScrollView(
            child: Column(
              children: <Widget>[
                SizedBox(height: 20),
                // Profile Image
                Container(
                  width: 120,
                  height: 120,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    image: DecorationImage(
                      image: AssetImage('assets/images/userImage.png'), // Using existing asset
                      fit: BoxFit.cover,
                    ),
                    boxShadow: <BoxShadow>[
                      BoxShadow(
                          color: AppTheme.grey.withOpacity(0.6),
                          offset: const Offset(4, 4),
                          blurRadius: 8.0),
                    ],
                  ),
                ),
                SizedBox(height: 16),
                // Name
                Text(
                  'Chris Hemsworth',
                  style: TextStyle(
                    fontSize: 24,
                    fontWeight: FontWeight.bold,
                    color: isLightMode ? AppTheme.darkText : AppTheme.white,
                  ),
                ),
                SizedBox(height: 8),
                // Bio
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 32.0),
                  child: Text(
                    'AI Enthusiast | Flutter Developer | Coffee Lover\nCreating amazing experiences with code.',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 16,
                      color: isLightMode ? AppTheme.grey : AppTheme.white,
                    ),
                  ),
                ),
                SizedBox(height: 24),
                // Stats
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    _buildStatItem("Sales", "1,204", isLightMode),
                    _buildStatItem("Classes", "48", isLightMode),
                    _buildStatItem("Rating", "4.9", isLightMode),
                  ],
                ),
                SizedBox(height: 32),
                // Badges
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Badges',
                        style: TextStyle(
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                          color: isLightMode ? AppTheme.darkText : AppTheme.white,
                        ),
                      ),
                      SizedBox(height: 16),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceAround,
                        children: [
                          _buildBadge(FontAwesomeIcons.trophy, "Top Seller", Colors.amber, isLightMode),
                          _buildBadge(FontAwesomeIcons.robot, "AI Pioneer", Colors.blue, isLightMode),
                          _buildBadge(FontAwesomeIcons.heart, "Community Choice", Colors.red, isLightMode),
                        ],
                      ),
                    ],
                  ),
                ),
                SizedBox(height: 32),
                // Edit Profile Button
                 Padding(
                    padding: const EdgeInsets.only(top: 16),
                    child: Center(
                      child: Container(
                        width: 160,
                        height: 48,
                        decoration: BoxDecoration(
                          color: isLightMode ? Colors.blue : Colors.white,
                          borderRadius:
                              const BorderRadius.all(Radius.circular(4.0)),
                          boxShadow: <BoxShadow>[
                            BoxShadow(
                                color: Colors.grey.withOpacity(0.6),
                                offset: const Offset(4, 4),
                                blurRadius: 8.0),
                          ],
                        ),
                        child: Material(
                          color: Colors.transparent,
                          child: InkWell(
                            onTap: () {
                               Navigator.push(context, MaterialPageRoute(builder: (context) => EditProfileScreen()));
                            },
                            child: Center(
                              child: Padding(
                                padding: const EdgeInsets.all(4.0),
                                child: Text(
                                  'Edit Profile',
                                  style: TextStyle(
                                    fontWeight: FontWeight.w500,
                                    fontSize: 16,
                                    color: isLightMode
                                        ? Colors.white
                                        : Colors.black,
                                  ),
                                ),
                              ),
                            ),
                          ),
                        ),
                      ),
                    ),
                  ),
                  SizedBox(height: 32),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildStatItem(String label, String value, bool isLightMode) {
    return Column(
      children: [
        Text(
          value,
          style: TextStyle(
            fontSize: 22,
            fontWeight: FontWeight.bold,
            color: isLightMode ? AppTheme.darkText : AppTheme.white,
          ),
        ),
        SizedBox(height: 4),
        Text(
          label,
          style: TextStyle(
            fontSize: 14,
            color: isLightMode ? AppTheme.grey : AppTheme.white.withOpacity(0.6),
          ),
        ),
      ],
    );
  }

  Widget _buildBadge(IconData icon, String label, Color color, bool isLightMode) {
    return Column(
      children: [
        Container(
          padding: EdgeInsets.all(12),
          decoration: BoxDecoration(
            color: color.withOpacity(0.1),
            shape: BoxShape.circle,
          ),
          child: FaIcon(
            icon,
            color: color,
            size: 32,
          ),
        ),
        SizedBox(height: 8),
        Text(
          label,
          style: TextStyle(
            fontSize: 12,
            fontWeight: FontWeight.w500,
            color: isLightMode ? AppTheme.darkText : AppTheme.white,
          ),
        ),
      ],
    );
  }
}
