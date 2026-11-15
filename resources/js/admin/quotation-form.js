/**
 * AzkaMandiri ERP - Quotation Form Component
 * Handles dynamic row insertion, inventory product lookup, dimensions, and live financial totals.
 */

document.addEventListener('alpine:init', () => {
    Alpine.data('quotationForm', () => ({
        items: [],
        products: [],
        discount: 0,
        tax: 0,
        isCustomCustomer: false,

        init() {
            const dataEl = document.getElementById('quotation-form-data');
            if (dataEl) {
                try {
                    this.products = JSON.parse(dataEl.dataset.products || '[]');
                } catch (e) {
                    this.products = [];
                }

                try {
                    const initialItems = JSON.parse(dataEl.dataset.items || '[]');
                    this.items = initialItems.length > 0 ? initialItems : [this.newItem()];
                } catch (e) {
                    this.items = [this.newItem()];
                }

                this.discount = parseFloat(dataEl.dataset.discount) || 0;
                this.tax = parseFloat(dataEl.dataset.tax) || 0;
                this.isCustomCustomer = dataEl.dataset.isCustomCustomer === 'true';
            } else {
                this.items = [this.newItem()];
            }

            this.$nextTick(() => {
                if (window.renderIcons) window.renderIcons();
            });
        },

        newItem() {
            return {
                product_id: '',
                item_name: '',
                dimensions: '',
                quantity: 1,
                unit_name: 'unit',
                unit_price: 0
            };
        },

        addItem() {
            this.items.push(this.newItem());
            this.$nextTick(() => {
                if (window.renderIcons) window.renderIcons();
            });
        },

        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            }
        },

        onProductSelect(item) {
            if (!item.product_id) return;
            const found = this.products.find(p => String(p.id) === String(item.product_id));
            if (found) {
                item.item_name = found.name;
                item.unit_name = found.unit || 'unit';
                item.unit_price = found.price || 0;
            }
        },

        getItemTotal(item) {
            const q = parseFloat(item.quantity) || 0;
            const p = parseFloat(item.unit_price) || 0;
            return q * p;
        },

        get subtotal() {
            return this.items.reduce((sum, item) => sum + this.getItemTotal(item), 0);
        },

        get grandTotal() {
            const d = parseFloat(this.discount) || 0;
            const t = parseFloat(this.tax) || 0;
            return Math.max(0, (this.subtotal - d) + t);
        },

        formatIDR(val) {
            return 'Rp ' + Math.round(val || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    }));
});
