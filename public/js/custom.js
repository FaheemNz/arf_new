$(function () {
    $("#has_laptop").click(function () {
        if ($("#has_laptop").is(":checked")) {
            $("#laptop-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_laptop_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#laptop-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_laptop_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_tablet").click(function () {
        if ($("#has_tablet").is(":checked")) {
            $("#tablet-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_tablet_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#tablet-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_tablet_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_sim").click(function () {
        if ($("#has_sim").is(":checked")) {
            $("#sim-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_sim_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#sim-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_sim_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_desktop").click(function () {
        if ($("#has_desktop").is(":checked")) {
            $("#desktop-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_desktop_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#desktop-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_desktop_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_monitor").click(function () {
        if ($("#has_monitor").is(":checked")) {
            $("#monitor-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_monitor_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#monitor-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_monitor_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_mobile").click(function () {
        if ($("#has_mobile").is(":checked")) {
            $("#mobile-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_mobile_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#mobile-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_mobile_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $('#arf_emp_id').on("change", function (e) {
        let empId = $(this).val();

        if (/[0-9]{3,7}/.test(empId)) {

            $('#site-loader').removeClass("d-none");

            $.ajax({
                method: "GET",
                url: "/get-ad-employee/" + empId,
                success: function (response) {

                    if (response.success == true && response.user.length) {
                        $("#site-loader").addClass("d-none");

                        let theUser = response.user[0];

                        if (theUser.Enabled == false) {
                            alert("The User is not Enabled in AD. Please check with System Administrator");

                            throw new Error("The User is not Enabled in AD. Please check with System Administrator");
                        }

                        $("#arf-name").val(theUser.FirstName + " " + theUser.LastName);
                        $("#arf-email").val(theUser.EmailAddress);
                        $("#signature-name").text(theUser.FirstName + " " + theUser.LastName);
                    } else {
                        alert("No Employee Found with the Employee ID provided");

                        $("#site-loader").addClass("d-none");
                    }
                },
                error: function (error) {
                    console.log(error);

                    $("#site-loader").addClass("d-none");

                    alert("Please enter a valid Employee ID");
                },
            });
        } else {
            alert("Please enter a valid Employee ID");
        }
    });
});

let modal = new bootstrap.Modal(document.getElementById("asset-search-modal"));

$(document).on("click", ".searchModalTrigger", function () {
    let tableName = $(this).attr("data-table"),
        assetCode = $(this).attr("data-field-asset-code"),
        assetBrand = $(this).attr("data-field-brand");

    if (!tableName || !assetCode || !assetBrand) {
        console.log(tableName, assetCode, assetBrand);

        alert("Script Parsing Issue.");

        return;
    }

    searchModalTrigger(tableName, assetCode, assetBrand);
});

function searchModalTrigger(tableName, assetCode, assetBrand) {
    $("#table").val(tableName);
    $("#c_asset_code").val(assetCode);
    $("#c_brand").val(assetBrand);
    $("#is-available").addClass("d-none");

    let assetTypeAjax = $("#asset_code_ajax");

    assetTypeAjax.empty();

    $.ajax({
        method: "GET",
        url: "/search-asset-availability",
        data: {
            table: tableName
        },
        success: function (response) {
            if (response.success == true) {
                assetTypeAjax.select2({
                    placeholder: "Select Asset",
                    dropdownParent: $('#asset-search-modal'),
                    width: "470px",
                    data: response.data
                });
            } else {
                alert("No Asset is Available");
            }
        },
        error: function (error) {
            console.log(error);

            alert("Some Error Occured");
        },
    });

    modal.show();
}

function fillAssetDetails() {
    let fromAjaxAsset = $("#asset_code_ajax").select2("data"),
        table = $('#table').val();

    if (fromAjaxAsset.length == 0 || fromAjaxAsset === undefined) {
        alert("Please select a valid asset");

        return;
    }

    console.log(fromAjaxAsset);

    let theCode = fromAjaxAsset[0].text

    table = table.slice(0, -1);

    $("#arf_" + table + "_asset_code").val(theCode);

    modal.hide();
}

function preSelectOfficeLocation(deptId) {
    let officeLocations = [
        { dept_id: 1, floor: 2 }, // Asset        => 8
        { dept_id: 2, floor: 1 }, // Audit        => 5,
        { dept_id: 3, floor: 2 }, // CRM          => 8
        { dept_id: 4, floor: 5 }, // VCM          => 14
        { dept_id: 5, floor: 5 }, // Sales        => 14
        { dept_id: 6, floor: 5 }, // S.Admin      => 14
        { dept_id: 7, floor: 6 }, // Techtiq      => 15
        { dept_id: 8, floor: 6 }, // Legacious    => 15
        { dept_id: 9, floor: 6 }, // Eng          => 15,
        { dept_id: 10, floor: 6 }, // PMO          => 15,
        { dept_id: 11, floor: 6 }, // Gardinia     => 15,
        { dept_id: 12, floor: 5 }, // Procurement  => 14,
        { dept_id: 13, floor: 1 }, // Finance      => 5,
        { dept_id: 14, floor: 2 }, // Handover     => 8,
        { dept_id: 15, floor: 4 }, // Agency       => 13,
        { dept_id: 16, floor: 4 }, // Telesales    => 13,
        { dept_id: 17, floor: 4 }, // Marketing    => 13,
        { dept_id: 18, floor: 5 }, // Agency       => 13,
        { dept_id: 19, floor: 2 }, // Admin        => 8,
        { dept_id: 20, floor: 2 }, // Operation    => 8,
    ];

    if (!deptId) {
        return;
    }

    let theOffice = officeLocations.find((o) => o.dept_id == deptId).floor;

    $("#arf_office_location option[value=" + theOffice + "]").prop(
        "selected",
        true
    );
}

function loadBrands(elem) {
    let type = elem.value,
        assetBrand = $("#asset_brand");

    if (!type) {
        return;
    }

    assetBrand.empty();

    $.ajax({
        url: "/get-brands",
        method: "GET",
        data: {
            type: type
        },
        success: function (response) {
            if (response.success == true) {
                assetBrand.append(`<option value="">Select</option>`);
                response.data.forEach(brand => {
                    assetBrand.append(`<option value="${brand}">${brand}</option>`);
                });
            } else {
                alert("No Brand found");
            }
        },
        error: function (error) {
            console.log(error);

            alert("Some Error Occured. Please try again later")
        }
    });
}