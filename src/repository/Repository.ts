import ResponseAPI from "./ResponseAPI";

export default interface Repository
{
	getAll(): Promise<ResponseAPI[]>;
	get(model: ResponseAPI): Promise<ResponseAPI>;
	add(model: ResponseAPI): Promise<boolean>;
	delete(model: ResponseAPI): Promise<boolean>;
	update(model: ResponseAPI): Promise<boolean>;
}