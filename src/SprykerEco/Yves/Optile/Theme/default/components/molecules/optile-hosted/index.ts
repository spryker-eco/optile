import './optile-hosted.scss';
import register from 'ShopUi/app/registry';
export default register('optile-hosted', () => import(/* webpackMode: "lazy" */'./optile-hosted'));
