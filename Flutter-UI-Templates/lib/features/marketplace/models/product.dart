class Product {
  Product({
    required this.id,
    required this.title,
    required this.author,
    required this.price,
    required this.rating,
    required this.reviewCount,
    required this.imagePath,
    required this.description,
  });

  final String id;
  final String title;
  final String author;
  final double price;
  final double rating;
  final int reviewCount;
  final String imagePath;
  final String description;

  bool get isCommunityChoice => rating > 4.8;

  static List<Product> popularProducts = [
    Product(
      id: '1',
      title: 'Flutter Masterclass',
      author: 'John Doe',
      price: 49.99,
      rating: 4.9,
      reviewCount: 120,
      imagePath: 'assets/fitness_app/area1.png',
      description: 'Complete guide to Flutter development.',
    ),
    Product(
      id: '2',
      title: 'Dart Essentials',
      author: 'Jane Smith',
      price: 29.99,
      rating: 4.5,
      reviewCount: 80,
      imagePath: 'assets/fitness_app/area2.png',
      description: 'Learn Dart from scratch.',
    ),
    Product(
      id: '3',
      title: 'Advanced State Management',
      author: 'Bob Johnson',
      price: 39.99,
      rating: 4.85,
      reviewCount: 200,
      imagePath: 'assets/fitness_app/area3.png',
      description: 'Deep dive into Provider, Riverpod, and Bloc.',
    ),
     Product(
      id: '4',
      title: 'UI Design for Devs',
      author: 'Alice Brown',
      price: 19.99,
      rating: 4.2,
      reviewCount: 50,
      imagePath: 'assets/fitness_app/runner.png',
      description: 'Make your apps look great.',
    ),
  ];
}
