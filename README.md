# Edwiser — Enroll on Processing (WordPress MU-plugin)

**Author:** [Mindful Design](https://mindfuldesign.me)  
**Support:** [support@mindfuldesign.me](mailto:support@mindfuldesign.me)  
**Repository:** [github.com/MindfulDesign-me/edwiser-enroll-on-processing](https://github.com/MindfulDesign-me/edwiser-enroll-on-processing)  
**GitHub:** [@MindfulSupport](https://github.com/MindfulSupport)

Edwiser Bridge Pro’s WooCommerce integration enrolls learners when an order reaches **Completed**. If your shop also sells physical goods, orders may stay in **Processing** until items ship—so course buyers are not enrolled until much later.

This **must-use plugin** adds an optional enrollment on **Processing**, using Edwiser’s own `handle_order_complete()` logic (same as Completed). Order meta `_is_processed` prevents duplicate enrollment when the order later becomes Completed.

## Requirements

- WordPress + WooCommerce  
- **Edwiser Bridge Pro** with Woo Integration enabled  
- Edwiser Bridge (free) as required by Pro  

## Install

1. Copy `edwiser-enroll-on-processing.php` to your site’s `wp-content/mu-plugins/` directory (create `mu-plugins` if it does not exist).  
2. In **wp-admin**, go to **Edwiser Bridge → Settings → Woo Integration**.  
3. Under **Course enrollment timing**, enable **Enroll when order is Processing**.  
4. Test with a course order that stays in Processing (e.g. mixed with physical products).

## License

GPL-2.0-or-later (same family as WordPress).
