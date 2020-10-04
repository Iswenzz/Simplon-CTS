import Model from "../model/Model";

export default interface Repository {
	getAll(): Promise<Model[]>;
	get(model: Model): Promise<Model>;
	add(model: Model): Promise<boolean>;
	delete(model: Model): Promise<boolean>;
	update(model: Model): Promise<boolean>;
}