import 'package:best_flutter_ui_templates/features/marketplace/marketplace_screen.dart';
import 'package:best_flutter_ui_templates/features/marketplace/views/product_item_view.dart';
import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';

void main() {
  testWidgets('MarketplaceScreen renders and displays products', (WidgetTester tester) async {
    // Build our app and trigger a frame.
    await tester.pumpWidget(const MaterialApp(
      home: MarketplaceScreen(),
    ));

    // Wait for animations and futures
    await tester.pumpAndSettle();

    // Verify that Marketplace title is present
    expect(find.text('Marketplace'), findsOneWidget);

    // Verify that products are displayed
    expect(find.byType(ProductItemView), findsWidgets);

    // Verify "Community Choice" logic (at least one item should have the border/badge)
    // We can check if "Choice" text is present (which is the badge text)
    expect(find.text('Choice'), findsWidgets);
  });
}
