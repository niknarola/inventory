<div class="row">
    <div class="table-responsive">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Cosmetic Notes:</label>
                    <textarea class="form-control" readonly="true" disabled="true"><?= ($notes['cosmetic_issues_text']!=null || $notes['cosmetic_issues_text']!='') ? implode(',',json_decode($notes['cosmetic_issues_text'], true)) : 'Not available' ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fail Notes:</label>
                    <textarea class="form-control" readonly="true" disabled="true"><?= ($notes['fail_text'] !=null || $notes['fail_text'] !='') ? $notes['fail_text'] : 'Not Available' ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="table-responsive">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Receive Notes:</label>
                    <textarea class="form-control" readonly="true" disabled="true"><?= ($notes['recv_notes'] !=null || $notes['recv_notes'] !='') ? $notes['recv_notes'] : 'Not Available' ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tech Notes:</label>
                    <textarea class="form-control" readonly="true" disabled="true"><?= ($notes['tech_notes'] !=null || $notes['tech_notes'] !='') ? $notes['tech_notes'] : 'Not Available' ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="table-responsive">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Packout Notes:</label>
                    <textarea class="form-control" readonly="true" disabled="true"><?= ($notes['packaging_notes'] !=null || $notes['packaging_notes'] !='') ? $notes['packaging_notes'] : 'Not Available' ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Inspection Notes:</label>
                    <textarea class="form-control" readonly="true" disabled="true"><?= ($notes['inspection_notes'] !=null || $notes['inspection_notes'] !='') ? $notes['inspection_notes'] : 'Not Available' ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Repair Notes:</label>
                    <textarea class="form-control" readonly="true" disabled="true"><?= ($notes['repair_notes'] !=null || $notes['repair_notes'] !='') ? $notes['repair_notes'] : 'Not Available' ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
