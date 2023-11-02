<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>
	<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bootstrapModal">
	Launch demo modal
	</button> -->
	<?php if(session()->getFlashdata('success')): ?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<strong><?= session()->getFlashdata('success') ?></strong>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
	<?php endif; ?>
    <div id="basicdiagram"></div>
	<?= $this->include('components/modal'); ?>
    <script>
        let control;
        let timer = null;
        let directors = <?= json_encode($directors) ?>;
        let divisions = <?= json_encode($divisions) ?>;
        let departements = <?= json_encode($departements) ?>;
        let sections = <?= json_encode($sections) ?>;
        let staff = <?= json_encode($staff) ?>;
        let countEmployee = <?= json_encode($countEmployee) ?>;
        document.addEventListener("DOMContentLoaded", function () {
            let options = new primitives.OrgConfig();
            let items = [];
            directors.forEach(element => {
                items.push(
                    new primitives.OrgItemConfig({
                        id: element.kode_direktorate,
                        parent: null,
                        title: element.nama_jabatan,
                        description: `Kode Jabatan : ${element.kode_jabatan}`,
                        groupTitle: "Director",
                        itemTitleColor: primitives.Colors = '#FF9AA2',
                        // image: "/api/images/photos/a.png",
                    }));
            });
            divisions.forEach(element => {
                items.push(
                    new primitives.OrgItemConfig({
                        id: element.kode_jabatan,
                        parent: element.kode_direktorate,
                        title: element.nama_jabatan,
                        groupTitle: "Division Head",
                        description: `Kode Jabatan : ${element.kode_jabatan}`,
                        itemTitleColor: primitives.Colors = '#FFB7B2',
                        // image: null,
                    }));
            });
            departements.forEach(element => {
                items.push(
                    new primitives.OrgItemConfig({
                        id: element.kode_jabatan,
                        parent: `${element.kode_direktorate}${element.kode_divisi}`,
                        title: element.nama_jabatan,
                        groupTitle: "Departement Head",
                        description: `Kode Jabatan : ${element.kode_jabatan}`,
                        itemTitleColor: primitives.Colors = '#FFDAC1',
                        // image: null,
				}));
			});
			sections.forEach(element => {
				if(element.kode_jabatan =='ABCK') {
					// console.table(element)
					console.log(element.kode_jabatan)
				}
				items.push(
					new primitives.OrgItemConfig({
					id: element.kode_jabatan,
					parent: `${element.kode_direktorate}${element.kode_divisi}${element.kode_departemen}`,
					title: element.nama_jabatan,
					groupTitle: "Section Head",
					description: `Kode Jabatan : ${element.kode_jabatan}`,
					itemTitleColor: primitives.Colors = '#E2F0CB',
					// image: null,
				}));
            });
            staff.forEach(element => {
				if(element.kode_jabatan =='AAAAJ') {
					console.table(element,element.kode_departemen)
					console.log(`${element.kode_direktorate}${element.kode_divisi}${element.kode_departemen}${element.kode_staff}`)
				}
                items.push(
                    new primitives.OrgItemConfig({
                        id: element.kode_jabatan,
                        parent: `${element.kode_direktorate}${element.kode_divisi}${element.kode_departemen}${element.kode_section_head}`,
                        title: element.nama_jabatan,
                        groupTitle: "Staff",
                        description: `Kode Jabatan : ${element.kode_jabatan}`,
                        itemTitleColor: primitives.Colors = '#B5EAD7',
                        // image: null,
                    }));
            });
            options.items = items;
            options.pageFitMode = primitives.PageFitMode.AutoSize;
            options.showFrame = false;
            // options.autoSizeMinimum = new primitives.Size(2020,1000);
            options.hasButtons = primitives.Enabled.True;
            // options.cursorItem = 0;
            // options.hasSelectorCheckbox = primitives.Enabled.True;
            options.templates = [myTemplate()];
            options.onItemRender = onTemplateRender;
            options.defaultTemplateName = "employeeTemplate";
            control = primitives.OrgDiagram(
                document.getElementById("basicdiagram"),
                options
            );
            function onTemplateRender(event, data) {
				switch (data.renderingMode) {
					case primitives.RenderingMode.Create:
						/* Initialize template content here */
						break;
					case primitives.RenderingMode.Update:
						/* Update template content here */
						break;
				}

				var itemConfig = data.context;

				if (data.templateName == "employeeTemplate") {
					var element = data.element;

					element.firstChild.style.backgroundColor = itemConfig.itemTitleColor || primitives.Colors.RoyalBlue;
					element.firstChild.firstChild.textContent = itemConfig.title;

					// var photo = element.childNodes[1].firstChild;
					// photo.src = itemConfig.image;
					// photo.alt = itemConfig.title;

					// element.childNodes[2].textContent = itemConfig.phone;
					// element.childNodes[3].textContent = itemConfig.email;
					element.childNodes[1].textContent = itemConfig.description;
					element.childNodes[2].textContent = itemConfig.percent * 100.0 + '%';
				}
			}

			function myTemplate() {
				var result = new primitives.TemplateConfig();
				result.name = "employeeTemplate";

				result.itemSize = new primitives.Size(180, 120);
				result.minimizedItemSize = new primitives.Size(3, 3);

				result.itemTemplate = ["div",
					{
						"style": {
							width: result.itemSize.width + "px",
							height: result.itemSize.height + "px"
						},
						"class": ["bp-item", "bp-corner-all", "bt-item-frame"]
					},
					["div",
						{
							name: "titleBackground",
							style: {
								top: "2px",
								left: "2px",
								width: "216px",
								height: "20px",
								overflow: "hidden"
							},
							"class": ["bp-item", "bp-corner-all", "bp-title-frame"]
						},
						["div",
							{
								name: "title",
								style: {
									top: "2px",
									left: "2px",
									width: "208px",
									height: "18px",
									fontSize: "14px",
									overflow: "hidden",
                                    color:"#000000",
                                    fontWeight:"bold"
								},
								"class": ["bp-item", "bp-title"]
							}
						]
					],
					["div",
						{
							name: "description",
							style: {
								top: "24px",
								left: "5px",
								width: "162px",
								height: "36px",
								fontSize: "10px",
								overflow: "hidden",
                                fontSize: "13px",
							},
							"class": "bp-item"
						}
					],
					["div",
						{
							name: "label",
							style: {
								top: "-20px",
								left: "3px",
								width: "208px",
								height: "20px",
								fontSize: "14px",
								textAlign: "center",
								overflow: "hidden"
							},
							"class": "bp-item"
						}
					]
				];
				return result;
			}

            // options.annotations = [
            //     {
            //         annotationType: primitives.AnnotationType.Level,
            //         levels: [0],
            //         title: "Level 0",
            //         titleColor: primitives.Colors.RoyalBlue,
            //         offset: new primitives.Thickness(0, 0, 0, -1),
            //         lineWidth: new primitives.Thickness(0, 0, 0, 0),
            //         opacity: 0,
            //         borderColor: primitives.Colors.Gray,
            //         fillColor: primitives.Colors.Gray,
            //         lineType: primitives.LineType.Dotted
            //     },
            //     new primitives.LevelAnnotationConfig({
            //         annotationType: primitives.AnnotationType.Level,
            //         levels: [1],
            //         title: "Level 1",
            //         titleColor: primitives.Colors.Green,
            //         offset: new primitives.Thickness(0, 0, 0, -1),
            //         lineWidth: new primitives.Thickness(0, 0, 0, 0),
            //         opacity: 0.08,
            //         borderColor: primitives.Colors.Gray,
            //         fillColor: primitives.Colors.Gray,
            //         lineType: primitives.LineType.Dotted
            //     })
            // ],
            options.onButtonsRender = function (data) {
				var itemConfig = data.context;
				var element = data.element;
				element.innerHTML = "";
				element.appendChild(primitives.JsonML.toHTML(["div",
					{
					class: "btn-group-vertical btn-group-sm"
					},
					["button", 
						{
							"type": "button",
							"data-buttonname": "delete",
							"class":"btn btn-light"
						},
						["i", { "class": "bi bi-x-circle-fill text-danger" }]
					],
					["a", 
						{
							"href": "/hierarchy/edit/"+itemConfig.id,
							"data-buttonname": "edit",
							"class":"btn btn-light"
						},
						["i", { "class": "bi bi-pencil-square text-warning", }]
					],
					["a", 
						{
							"href": "/hierarchy/add/"+itemConfig.id,
							"data-buttonname": "link",
							"class":"btn btn-light"
						},
						["i", { "class": "bi bi-person-plus-fill text-success", }]
					]
				]));
			};
			options.onButtonClick = function (e, data) {
				// console.log(data.id)
				const myModal = new bootstrap.Modal(document.getElementById('bootstrapModal'));
				const modalLabel = document.getElementById('modalLabel');
				const modalContent = document.getElementById('modalContent');
				const deleteForm = document.getElementById('delete-form');
				const submitButton = document.getElementById('submit-button');
				let message,linkDelete;
				if(data.name == 'link'){
					return;
				}else if(data.name == 'delete'){
					 message = `Apakah anda yakin ingin menghapus ${data.context.title}`;
					 linkDelete = "/hierarchy/delete/"+data.context.id;
					 submitButton.addEventListener('click',function(){
						 deleteForm.action = linkDelete;
						 deleteForm.submit();
					 });
					 myModal.show();
					 modalLabel.innerHTML = message;
				}else if(data.name =='edit'){
					console.log('hehe');
				}
			};
        });
    </script>
<?= $this->endSection() ?>