import Component from 'ShopUi/models/component';
// import ScriptLoader from 'ShopUi/components/molecules/script-loader/script-loader';
import $ from 'jquery/dist/jquery';
import '../../../third-party/op-payment-widget/op-payment-widget-v3-3.6.0.min.js';

export default class OptileHosted extends Component {
    protected form: HTMLElement;
    // protected scriptLoader: ScriptLoader;
    
    protected readyCallback(): void {}

    protected init(): void {
        this.form = <HTMLElement>this.getElementsByClassName(`${this.jsName}__form`)[0];
        // this.scriptLoader = <ScriptLoader>this.getElementsByTagName('script-loader')[0];

        $(this.form).checkoutList();
        // console.log(this.scriptLoader);
    }
}
