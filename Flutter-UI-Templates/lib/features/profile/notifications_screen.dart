import 'package:best_flutter_ui_templates/app_theme.dart';
import 'package:flutter/material.dart';

class NotificationsScreen extends StatefulWidget {
  @override
  _NotificationsScreenState createState() => _NotificationsScreenState();
}

class _NotificationsScreenState extends State<NotificationsScreen> {
  // Mock notifications data
  final List<Map<String, dynamic>> _notifications = [
    {
      "title": "New Sale!",
      "message": "You sold a 'Flutter UI Kit' license.",
      "time": "2 mins ago",
      "isRead": false,
    },
    {
      "title": "Badge Earned",
      "message": "You earned the 'Top Seller' badge!",
      "time": "1 hour ago",
      "isRead": false,
    },
    {
      "title": "New Follower",
      "message": "Sarah Johnson started following you.",
      "time": "5 hours ago",
      "isRead": true,
    },
    {
      "title": "System Update",
      "message": "The platform will be down for maintenance at midnight.",
      "time": "1 day ago",
      "isRead": true,
    },
  ];

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
            title: Text(
              "Notifications",
              style: TextStyle(
                color: isLightMode ? AppTheme.darkText : AppTheme.white,
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
          body: ListView.separated(
            padding: EdgeInsets.all(16),
            itemCount: _notifications.length,
            separatorBuilder: (context, index) => Divider(height: 1),
            itemBuilder: (context, index) {
              final notif = _notifications[index];
              return Container(
                padding: EdgeInsets.symmetric(vertical: 12, horizontal: 8),
                decoration: BoxDecoration(
                  color: notif['isRead']
                      ? Colors.transparent
                      : (isLightMode ? Colors.blue.withOpacity(0.05) : Colors.blue.withOpacity(0.1)),
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Row(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Unread indicator
                    if (!notif['isRead'])
                      Container(
                        margin: EdgeInsets.only(top: 6, right: 12),
                        width: 8,
                        height: 8,
                        decoration: BoxDecoration(
                          color: Colors.red,
                          shape: BoxShape.circle,
                        ),
                      )
                    else
                      SizedBox(width: 20),

                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              Text(
                                notif['title'],
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  fontSize: 16,
                                  color: isLightMode ? AppTheme.darkText : AppTheme.white,
                                ),
                              ),
                              Text(
                                notif['time'],
                                style: TextStyle(
                                  fontSize: 12,
                                  color: isLightMode ? AppTheme.grey : AppTheme.white.withOpacity(0.6),
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: 4),
                          Text(
                            notif['message'],
                            style: TextStyle(
                              fontSize: 14,
                              color: isLightMode ? AppTheme.darkText : AppTheme.white.withOpacity(0.8),
                            ),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              );
            },
          ),
        ),
      ),
    );
  }
}
