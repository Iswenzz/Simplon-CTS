class Deserializer<T>
{
	public instance: T;
	public data: Record<string, any>;

	public constructor(instance: T, data: Record<string, any>)
	{
		this.instance = instance;
		this.data = data;
	}

	public deserialize(): T
	{
		const rgx = new RegExp(/^\d{4}-\d{2}-\d{2}$/);
		Object.entries(this.data).forEach(([k, v]) => rgx.test(v) ? this.data[k] = new Date(v) : null);
		Object.assign(this.instance, this.data);
		
		return this.instance;
	}
}

export default Deserializer;