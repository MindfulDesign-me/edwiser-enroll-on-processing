# Edwiser — Enroll on Processing (WordPress MU-plugin)

**Author:** [MindfulDesign](https://mindfuldesign.me)  
**Issues & feedback:** [GitHub Issues](https://github.com/MindfulDesign-me/edwiser-enroll-on-processing/issues)  
**Repository:** [github.com/MindfulDesign-me/edwiser-enroll-on-processing](https://github.com/MindfulDesign-me/edwiser-enroll-on-processing)

Edwiser Bridge Pro’s WooCommerce integration enrolls customers in Moodle when an order reaches **Completed**. If a store also sells physical goods, orders may stay in **Processing** until items ship—so course purchases may not enroll until much later.

This **must-use plugin** adds an optional enrollment on **Processing**, using Edwiser’s own `handle_order_complete()` logic (same as Completed). Order meta `_is_processed` prevents duplicate enrollment when the order later becomes Completed.

## Requirements

- WordPress + WooCommerce  
- **Edwiser Bridge Pro** with Woo Integration enabled  
- Edwiser Bridge (free) as required by Pro  

## Install

1. Copy `edwiser-enroll-on-processing.php` to the site’s `wp-content/mu-plugins/` directory (create `mu-plugins` if it does not exist).  
2. In **wp-admin**, go to **Edwiser Bridge → Settings → Woo Integration**.  
3. Under **Course enrollment timing**, enable **Enroll when order is Processing**.  
4. Test with a course order that stays in Processing (e.g. mixed with physical products).

## Disclaimer

This software is provided **as-is**, without warranty of any kind. **MindfulDesign** accepts **no responsibility** for any loss, damage, or problems that may result from using it—including incorrect enrollments, conflicts with other plugins or themes, or issues with Edwiser Bridge, WooCommerce, or Moodle.

**Test thoroughly** on a staging or cloned copy of the site before relying on it in production.

Bug reports and suggestions are welcome via **[GitHub Issues](https://github.com/MindfulDesign-me/edwiser-enroll-on-processing/issues)** (no other support channel is published in this repository).

## License

GPL-2.0-or-later (same family as WordPress).
