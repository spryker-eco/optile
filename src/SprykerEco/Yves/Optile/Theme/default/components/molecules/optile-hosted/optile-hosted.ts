declare var $;
import Component from 'ShopUi/models/component';
import '../../../third-party/op-payment-widget/op-payment-widget-v3.js';

export default class OptileHosted extends Component {
    protected form: HTMLElement;
    
    protected readyCallback(): void {}

    protected init(): void {
        this.form = <HTMLElement>document.getElementById(`${this.name}`);

        this.initPayment();
    }

    protected initPayment(): void {
        $(this.form).checkoutList({
            payButton: this.submitId,
            baseUrl: this.baseUrl,
            listId: this.longId
        });
    }

    protected get submitId(): string {
        return this.getAttribute('data-submit-id');
    }

    protected get longId(): string {
        return this.getAttribute('data-long-id');
    }

    protected get baseUrl(): string {
        return this.getAttribute('data-base-url');
    }
}
