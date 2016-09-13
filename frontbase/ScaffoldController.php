<?
class ScaffoldController extends PortalController{
	function __construct($model) {
		parent::__construct();
		$this->model = $model;
		$this->tool_name = $this->model."Tool";
	}
	function index() {
		$tool = new $this->tool_name;
		$this->setData("list_".strtolower($this->model),$tool->find_all());
		$this->page_file = "list";
	}
	function create() {
		$item = new $this->model();
		$this->setData(strtolower($this->model),$item);
		$this->page_file = "create";
	}

	function insert() {
		//TODO: Todas las operaciones detras de un post?
		//echo var_dump($_POST);
		$item = new $this->model();
		$item->update_attributes($_POST[strtolower($this->model)]);
		if ($item->save()) {
			FlashMessage::set($this->model." creado(a)");
			redirect(url_for_action("index"));
		}
		else {
			$this->setData(strtolower($this->model),$item);
			$this->page_file = "create";
		}
	}
	function edit($id) {
		$tool = new $this->tool_name;
		$this->setData(strtolower($this->model) ,$tool->find($id));
		$this->page_file = "edit";
	}
	function save($id) {
		//TODO: Todas las operaciones detras de un post?
		$tool = new $this->tool_name;
		$item = $tool->find($id);
		$item->update_attributes($_POST[strtolower($this->model)]);

		
		if ($item->save()) {
			FlashMessage::set($this->model." modificado(a)");
		redirect(url_for_action("index"));

		}
		$this->setData(strtolower($this->model),$item);
	}
	function delete($id) {
		if (isset($_POST)) {
			$tool = new $this->tool_name;
			$item = $tool->find($id);
			if ($item && $item->delete()) {
				FlashMessage::set($this->model." eliminado(a)");
			}else {
				FlashMessage::set("Hubo un problema al eliminar");
			}
			redirect(url_for_action("index"));
		}
	}
	
	function delete_confirm($id) {
		$tool = new $this->tool_name;
		$this->setData(strtolower($this->model) ,$tool->find($id));
		$this->page_file = "delete_confirm";
	}
}