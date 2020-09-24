import Model from "../model/Model";

export default interface Controller {
	model: Model;

	setModel : (model: Model) => void;
	getModel : () => Model;
	fetchAll : () => Promise<Array<Model>>;
	fetch : () => Promise<Model>;
	add : () => Promise<boolean>;
	delete : () => Promise<boolean>;
}
