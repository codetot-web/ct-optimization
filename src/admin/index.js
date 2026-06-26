import { render } from '@wordpress/element';
import App from './App';

const root = document.getElementById('codetot-optimization-root');
if (root) {
	render(<App />, root);
}
