function getFullName(item) {
    return `${item.name[0]}.${item.fatherName[0]}. ${item.surname}`;
}

function getCompanyName(item) {
    return item.companyName || getFullName(item);
}

export {
    getFullName,
    getCompanyName
}