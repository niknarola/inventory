<div class="row">
    <div class="table-responsive">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Cosmetic Notes:</label>
                    <textarea class="form-control" readonly="true" disabled="true"><?= implode(',',json_decode($notes['cosmetic_issues_text'], true)); ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fail Notes:</label>
                    <textarea class="form-control" readonly="true" disabled="true"><?= $notes['fail_text']; ?></textarea>
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
                    <textarea class="form-control" readonly="true" disabled="true"><?= $notes['recv_notes']; ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tech Notes:</label>
                    <textarea class="form-control" readonly="true" disabled="true"><?= $notes['tech_notes']; ?></textarea>
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
                    <textarea class="form-control" readonly="true" disabled="true"><?= $notes['packaging_notes']; ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Inspection Notes:</label>
                    <textarea class="form-control" readonly="true" disabled="true"><?= $notes['inspection_notes']; ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
