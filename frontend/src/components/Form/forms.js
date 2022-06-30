





class Input extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return(
            <div className={'control'}>
                <label className={'label is-size-6'} htmlFor={this.props.name}>{this.props.name}</label>
                <input className={'input'} type={this.props.type} name={this.props.name.toLowerCase()}  />
            </div>
        );
    }
}