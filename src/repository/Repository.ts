import Model from "./Model";

/**
 * Default interface for a repository.
 */
export default interface Repository<M extends Model>
{
	getAll(): Promise<M[]>;
	get(model: M): Promise<M>;
	add(model: M): Promise<boolean>;
	delete(model: M): Promise<boolean>;
	update(model: M): Promise<boolean>;
}
