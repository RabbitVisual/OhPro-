import 'package:best_flutter_ui_templates/features/marketplace/models/product.dart';
import 'package:best_flutter_ui_templates/features/marketplace/views/product_item_view.dart';
import 'package:best_flutter_ui_templates/features/marketplace/views/product_detail_screen.dart';
import 'package:flutter/material.dart';

class ProductFeed extends StatefulWidget {
  const ProductFeed({Key? key, this.mainScreenAnimationController, this.mainScreenAnimation})
      : super(key: key);

  final AnimationController? mainScreenAnimationController;
  final Animation<double>? mainScreenAnimation;

  @override
  _ProductFeedState createState() => _ProductFeedState();
}

class _ProductFeedState extends State<ProductFeed>
    with TickerProviderStateMixin {
  AnimationController? animationController;
  List<Product> products = Product.popularProducts;
  late Future<bool> _dataFuture;

  @override
  void initState() {
    animationController = AnimationController(
        duration: const Duration(milliseconds: 2000), vsync: this);
    _dataFuture = getData();
    super.initState();
  }

  @override
  void dispose() {
    animationController?.dispose();
    super.dispose();
  }

  Future<bool> getData() async {
    await Future<dynamic>.delayed(const Duration(milliseconds: 50));
    return true;
  }

  @override
  Widget build(BuildContext context) {
    return AnimatedBuilder(
      animation: widget.mainScreenAnimationController!,
      builder: (BuildContext context, Widget? child) {
        return FadeTransition(
          opacity: widget.mainScreenAnimation!,
          child: Transform(
            transform: Matrix4.translationValues(
                0.0, 30 * (1.0 - widget.mainScreenAnimation!.value), 0.0),
            child: SizedBox(
              height: 280,
              width: double.infinity,
              child: FutureBuilder<bool>(
                future: _dataFuture,
                builder: (BuildContext context, AsyncSnapshot<bool> snapshot) {
                  if (!snapshot.hasData) {
                    return const SizedBox();
                  } else {
                    return ListView.builder(
                      padding: const EdgeInsets.only(
                          top: 0, bottom: 0, right: 16, left: 16),
                      itemCount: products.length,
                      scrollDirection: Axis.horizontal,
                      itemBuilder: (BuildContext context, int index) {
                        final int count =
                            products.length > 10 ? 10 : products.length;
                        final Animation<double> animation =
                            Tween<double>(begin: 0.0, end: 1.0).animate(
                                CurvedAnimation(
                                    parent: animationController!,
                                    curve: Interval((1 / count) * index, 1.0,
                                        curve: Curves.fastOutSlowIn)));
                        animationController?.forward();

                        return ProductItemView(
                          product: products[index],
                          animation: animation,
                          animationController: animationController!,
                          onTap: () {
                              Navigator.push(
                                context,
                                MaterialPageRoute(
                                  builder: (context) => ProductDetailScreen(product: products[index]),
                                ),
                              );
                          },
                        );
                      },
                    );
                  }
                },
              ),
            ),
          ),
        );
      },
    );
  }
}
