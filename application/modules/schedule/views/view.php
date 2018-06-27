<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Add Slider</a> </div>
		<h1><?php echo ( isset($slider_history) ) ? 'Update Existing Slider: ' : 'Add New Schedule: ' ?></h1>
	</div>
	<div class="container-fluid">
		<?php

		// echo "<pre>";
		// var_dump($slider_history);


		if( $this->session->flashdata('success_message') ){
			echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
		}
		elseif( $this->session->flashdata('error_message') ){
			echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
		}


		if( isset($slider_history) )
		{
			// echo "<pre>"; var_dump($notice_history);
			foreach ($slider_history as $slider);
		}
		?>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
						<h5><?php echo ( isset($slider_history) ) ? 'Update Slider: ' : 'Add schedule: ' ?></h5>
					</div>


<script>


$(document).ready(function(){
	$("#scheduler").kendoScheduler({
    date: new Date("2013/6/13"),
    startTime: new Date("2013/6/13 07:00 AM"),
    height: 600,
    views: [
        "day",
        { type: "week", selected: true },
        "month",
        "agenda"
    ],
    timezone: "Etc/UTC",
    dataSource: {
        batch: true,
        transport: {
            read: {
                url: "http://demos.telerik.com/kendo-ui/service/meetings",
                dataType: "jsonp"
            },
            update: {
                url: "http://demos.telerik.com/kendo-ui/service/meetings/update",
                dataType: "jsonp"
            },
            create: {
                url: "http://demos.telerik.com/kendo-ui/service/meetings/create",
                dataType: "jsonp"
            },
            destroy: {
                url: "http://demos.telerik.com/kendo-ui/service/meetings/destroy",
                dataType: "jsonp"
            },
            parameterMap: function(options, operation) {
                if (operation !== "read" && options.models) {
                    return {models: kendo.stringify(options.models)};
                }
            }
        },
        schema: {
            model: {
                id: "meetingID",
                fields: {
                    meetingID: { from: "MeetingID", type: "number" },
                    title: { from: "Title", defaultValue: "No title", validation: { required: true } },
                    start: { type: "date", from: "Start" },
                    end: { type: "date", from: "End" },
                    startTimezone: { from: "StartTimezone" },
                    endTimezone: { from: "EndTimezone" },
                    description: { from: "Description" },
                    recurrenceId: { from: "RecurrenceID" },
                    recurrenceRule: { from: "RecurrenceRule" },
                    recurrenceException: { from: "RecurrenceException" },
                    roomId: { from: "RoomID", nullable: true },
                    attendees: { from: "Attendees", nullable: true },
                    isAllDay: { type: "boolean", from: "IsAllDay" }
                }
            }
        }
    },
    resources: [
        {
            field: "roomId",
            dataSource: [
                { text: "Meeting Room 101", value: 1, color: "#6eb3fa" },
                { text: "Meeting Room 201", value: 2, color: "#f58a8a" }
            ],
            title: "Room"
        },
        {
            field: "attendees",
            dataSource: [
                { text: "Alex", value: 1, color: "#f8a398" },
                { text: "Bob", value: 2, color: "#51a0ed" },
                { text: "Charlie", value: 3, color: "#56ca85" }
            ],
            multiple: true,
            title: "Attendees"
        }
    ]
});
});
		
</script>	
	


		<div id="scheduler"></div>


			</div>
		</div>
	</div>
</div>
