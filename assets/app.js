/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// start the Stimulus application
import './bootstrap';


import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle';

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css'

// Формы
import './styles/forms/auth.css'
import './styles/forms/registration.css'

import './styles/detail-page/index.css'
import './styles/News-form/index.css'


import AOS from 'aos'
import 'aos/dist/aos.css';

AOS.init()
