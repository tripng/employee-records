﻿export default function OrgExtractNestedLayoutsTask(extractNestedLayoutsOptionTask, bindFamilyConnectorsTask) {
  function process(debug) {
    return false;
  }

  function getNestedLayoutParentConnectorIds() {
    return {};
  }

  function getNestedLayoutBottomConnectorIds() {
    return {};
  }

  function getBundles() {
    return [];
  }

  function getLayouts() {
    return {};
  }

  return {
    process: process,
    getNestedLayoutParentConnectorIds: getNestedLayoutParentConnectorIds,
    getNestedLayoutBottomConnectorIds: getNestedLayoutBottomConnectorIds,
    getBundles: getBundles,
    getLayouts: getLayouts
  };
};
