import 'package:best_flutter_ui_templates/features/marketplace/models/product.dart';
import 'package:best_flutter_ui_templates/features/marketplace/views/review_bottom_sheet.dart';
import 'package:best_flutter_ui_templates/fitness_app/fitness_app_theme.dart';
import 'package:flutter/material.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';

class ProductDetailScreen extends StatelessWidget {
  const ProductDetailScreen({Key? key, required this.product}) : super(key: key);

  final Product product;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: FitnessAppTheme.background,
      appBar: AppBar(
        title: Text(product.title, style: const TextStyle(color: FitnessAppTheme.darkText)),
        backgroundColor: FitnessAppTheme.white,
        iconTheme: const IconThemeData(color: FitnessAppTheme.darkText),
        elevation: 0,
      ),
      body: Column(
        children: [
          Expanded(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(24),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Center(
                    child: Container(
                      width: 150,
                      height: 150,
                      decoration: BoxDecoration(
                        color: FitnessAppTheme.nearlyWhite,
                        shape: BoxShape.circle,
                        boxShadow: <BoxShadow>[
                          BoxShadow(
                            color: FitnessAppTheme.grey.withOpacity(0.4),
                            offset: const Offset(4, 4),
                            blurRadius: 16,
                          ),
                        ],
                      ),
                      child: ClipOval(child: Image.asset(product.imagePath, fit: BoxFit.cover)),
                    ),
                  ),
                  const SizedBox(height: 24),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Expanded(
                        child: Text(
                          product.title,
                          style: const TextStyle(
                            fontFamily: FitnessAppTheme.fontName,
                            fontWeight: FontWeight.bold,
                            fontSize: 24,
                            color: FitnessAppTheme.darkText,
                          ),
                        ),
                      ),
                      if (product.isCommunityChoice)
                        const Icon(Icons.verified, color: Colors.amber),
                    ],
                  ),
                  const SizedBox(height: 8),
                  Text(
                    'by ${product.author}',
                    style: const TextStyle(
                      fontFamily: FitnessAppTheme.fontName,
                      fontSize: 16,
                      color: FitnessAppTheme.grey,
                    ),
                  ),
                  const SizedBox(height: 16),
                  Row(
                    children: [
                      RatingBarIndicator(
                        rating: product.rating,
                        itemBuilder: (context, index) => const Icon(
                          Icons.star,
                          color: Colors.amber,
                        ),
                        itemCount: 5,
                        itemSize: 20.0,
                        direction: Axis.horizontal,
                      ),
                      const SizedBox(width: 8),
                      Text(
                        '${product.rating} (${product.reviewCount} reviews)',
                        style: const TextStyle(
                          fontFamily: FitnessAppTheme.fontName,
                          fontSize: 14,
                          color: FitnessAppTheme.grey,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 24),
                  Text(
                    '\$${product.price}',
                    style: const TextStyle(
                      fontFamily: FitnessAppTheme.fontName,
                      fontWeight: FontWeight.bold,
                      fontSize: 28,
                      color: FitnessAppTheme.nearlyDarkBlue,
                    ),
                  ),
                  const SizedBox(height: 24),
                  const Text(
                    'Description',
                    style: TextStyle(
                      fontFamily: FitnessAppTheme.fontName,
                      fontWeight: FontWeight.bold,
                      fontSize: 18,
                      color: FitnessAppTheme.darkText,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    product.description,
                    style: const TextStyle(
                      fontFamily: FitnessAppTheme.fontName,
                      fontSize: 16,
                      color: FitnessAppTheme.grey,
                      height: 1.5,
                    ),
                  ),
                ],
              ),
            ),
          ),
          Container(
            padding: const EdgeInsets.all(24),
            decoration: const BoxDecoration(
              color: FitnessAppTheme.white,
              borderRadius: BorderRadius.only(
                topLeft: Radius.circular(32),
                topRight: Radius.circular(32),
              ),
              boxShadow: [
                 BoxShadow(
                  color: Colors.black12,
                  offset: Offset(0, -4),
                  blurRadius: 16,
                ),
              ],
            ),
            child: SizedBox(
              width: double.infinity,
              height: 48,
              child: ElevatedButton(
                onPressed: () {
                   showModalBottomSheet(
                    context: context,
                    isScrollControlled: true,
                    backgroundColor: Colors.transparent,
                    builder: (context) => const ReviewBottomSheet(),
                  );
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: FitnessAppTheme.nearlyDarkBlue,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(16),
                  ),
                ),
                child: const Text(
                  'Write a Review',
                  style: TextStyle(
                    fontFamily: FitnessAppTheme.fontName,
                    fontWeight: FontWeight.bold,
                    fontSize: 16,
                    color: Colors.white,
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
