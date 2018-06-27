
    <div id="content-container">
        <div id="content" class="clearfix">
            <div id="banner-homepage" style="margin-top: 20px; min-height: 400px;">
				<div class="left-side-bar">
					<h2>Student Name</h2>
					<ul class="student_bar">
						<li class = "<?php if($this->uri->segment(4)=='notice') {echo "active";} ?>"><a href="<?php echo base_url('frontend/panel/student/notice'); ?>">Notice</a></li>
						<li class = "<?php echo ($this->uri->segment(4)=='marksheet') ? 'active':''; ?>"><a href="<?php echo base_url('frontend/panel/student/marksheet'); ?>">Marksheet</a></li>
						<li class = "<?php echo ($this->uri->segment(4)=='booklist') ? 'active':''; ?>"><a href="<?php echo base_url('frontend/panel/student/booklist'); ?>">Booklist</a></li>
					</ul>
				</div>

				<div class="right_content">
					
						<?php
						if(isset($notice)){
						?>
						<ul class="notice">
						<h2>Notice List</h2>
						<?php
						foreach ($notice as $key => $value):
						?>
							<li><a href="<?php echo base_url('frontend/notices').'/'.$value->id; ?>"><?php echo $value->notice_title; ?></a></li>
						<?php 
						endforeach;
						echo "</ul>";
						}
						?>
						
						<!-- for Mark sheet -->
						<?php 
							if(isset($student_marksheet)){
						 ?>
						<h2>Marksheet of <?php echo $student[0]->name;   ?></h2>
						<table class="marksheet">
						<thead>
							<tr>
								<th>SL</th>
								<th>Subject</th>
								<th>total Marks</th>
								<th>Obtain Marks</th>
								<th>GPA Grade</th>
								<th>GPA Point</th>
							</tr>
						</thead>
						</tbody>
							<tr>
							<?php 
								$i = 1;
							foreach ($student_marksheet as $key => $value): ?>
								<td><?php echo $i++ ?></td>
								<td><?php echo $value->subject_name; ?></td>
								<td><?php echo $value->total_marks; ?></td>
								<td><?php echo $value->obtained_marks; ?></td>
								<td><?php echo gpa_by_obtained_marks($value->obtained_marks)[0]->letter_grade; ?></td>
								<td><?php echo gpa_by_obtained_marks($value->obtained_marks)[0]->grade_point; ?></td>
							<?php endforeach ?>
								
							</tr>
						</tbody>
						</table>
						<?php }?>



						<!-- For Booklist -->


						<?php 
							if(isset($student_booklist)){
						 ?>
						<h2>Booklist of <?php echo $student_booklist[0]->name; ?></h2>
						<table class="marksheet">
						<thead>
							<tr>
								<th>SL</th>
								<th>Book Title</th>
								<th>Writter</th>
								<th>Publisher</th>
							</tr>
						</thead>
						</tbody>
							<tr>
							<?php 
								$i = 1;
							foreach ($student_booklist as $key => $value): ?>
								<td><?php echo $i++ ?></td>
								<td><?php echo $value->book_title; ?></td>
								<td><?php echo $value->book_writter; ?></td>
								<td><?php echo $value->publisher; ?></td>
							<?php endforeach ?>
								
							</tr>
						</tbody>
						</table>
						<?php }?>
				</div>
            </div>
        </div>
    </div>