// app.js

require('./bootstrap');
import React from 'react';
import { render } from 'react-dom';
import { Router, Route, browserHistory } from 'react-router';

import GridSettingsForm from './components/GridSettingsForm';

render(
    <Router history={browserHistory}>
        <Route path="/admin/categories" component={GridSettingsForm} />
    </Router>,
    document.getElementById('grid_settings_form'));