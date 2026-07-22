const organizations = JSON.parse(
    document.getElementById('organization-data').textContent
);


function flattenOrganizations(items){

    let result = [];


    items.forEach(item => {

        result.push(item);


        if(item.children_recursive){

            result = result.concat(
                flattenOrganizations(item.children_recursive)
            );

        }

    });


    return result;

}



const organizationData = flattenOrganizations(organizations);



google.charts.load('current', {
    packages:['orgchart']
});


google.charts.setOnLoadCallback(drawOrganizationChart);



function drawOrganizationChart(){


    let data = new google.visualization.DataTable();


    data.addColumn('string','Name');
    data.addColumn('string','Manager');


    let rows = [];


    organizationData.forEach(item=>{


        rows.push([

            {

                v:item.id.toString(),

                f:`

                    <div class="org-card">

                        <img src="${item.photo 
                            ? '/storage/'+item.photo 
                            : '/assets/default-user.png'
                        }">


                        <b>
                            ${item.full_name}
                        </b>


                        <span>
                            ${item.position}
                        </span>


                    </div>

                `
            },


            item.parent_id 
                ? item.parent_id.toString()
                : ''

        ]);


    });



    data.addRows(rows);



    let chart = new google.visualization.OrgChart(
        document.getElementById('organization-chart')
    );


    chart.draw(data,{
        allowHtml:true,
        allowCollapse:true
    });


}