// GridSettingsForm.js

import React, { Component } from 'react';

class GridSettingsForm extends Component {
    render() {
        return (
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Active</th>
                            <th scope="col">Label</th>
                            <th scope="col">Type</th>
                            <th scope="col">Sortable</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody class="customtable">
                        <tr>
                            <td>
                                <label class="customcheckbox">
                                    <input type="checkbox" class="listCheckbox" id="grid-active"
                                        name="grid-active"/>
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="grid-active"
                                    name="grid-active" placeholder="Field Label"/>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="grid-active"
                                    name="grid-active" placeholder="Field Label" />
                            </td>
                            <td>
                                <input type="text" class="form-control" id="grid-active"
                                    name="grid-active" placeholder="Field Label" />
                            </td>
                            <td>
                                <input type="text" class="form-control" id="grid-active"
                                    name="grid-active" placeholder="Field Label" />
                            </td>
                        </tr>
                    </tbody>
                </table>            
            </div>
        )
    }
}
export default GridSettingsForm;      

// if (document.getElementById('grid_settings_form')) {
//     ReactDOM.render(<GridSettingsForm />, document.getElementById('grid_settings_form'));
// }